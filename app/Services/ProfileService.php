<?php
namespace App\Services;

use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class ProfileService extends BaseService
{
    protected $repository;

    protected $rules = [
        'cpf'=> 'required|unique:profiles,cpf',
        'sex'=> 'required',
        'birth'=> 'required',
        'marital_status'=> 'required',
        'phone'=> 'required',
    ];

    public function __construct()
    {
        $this->repository = new Profile();
    }

    public function find(): array | null
    {
        $data = $this->repository->where('user_id', Auth::user()->id)->first();
        if ($data == null) {
            return null;
        }
        return $data->toArray();
    }
    public function findUser(int $id): array | null
    {
        $data = $this->repository->where('user_id', $id)->first();
        if ($data == null) {
            return null;
        }
        return $data->toArray();
    }

    public function store(array $data): Profile | bool
    {
        // Verifica se o usuário já possui um perfil
        $getData = $this->find();
        if(isset($data['userId']) && $data['userId'] !== null){
            $getData = $this->findUser($data['userId']);
        }

        // Ajusta a regra de validação para ignorar o CPF do registro atual
        if ($getData) {
            $this->rules['cpf'] = 'required|unique:profiles,cpf,' . $getData['id'];
        } else {
            $this->rules['cpf'] = 'required|unique:profiles,cpf';
        }

        // Valida os dados com as regras ajustadas
        $this->validateForm($data, $data['userId'] ?? Auth::user()->id);

        if ($getData == null) {
            $data['user_id'] = Auth::user()->id;
            if(isset($data['userId']) && $data['userId'] !== null){
                $data['user_id'] = $data['userId'];
                unset($data['userId']);
            }

            return $this->create($data);
        }
        return $this->update($data, $getData['id']);
    }

    private function create(array $data): Profile
    {
        return $this->repository->create($data);
    }

    private function update(array $data, int $id): bool
    {
        $repo = $this->repository->find($id);
        return $repo->update($data);
    }
}