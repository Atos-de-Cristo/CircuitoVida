<?php
namespace App\Services;

use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class ProfileService extends BaseService
{
    protected $repository;

    protected $rules = [
        'cpf'=> 'required',
        'rg'=> 'required',
        'sex'=> 'required',
        'birth'=> 'required',
        'marital_status'=> 'required',
        'date_wedding'=> 'required',
        'marital_status'=> 'required',
        'zip_code'=> 'required',
        'address'=> 'required',
        'number'=> 'required',
        'complement'=> 'required',
        'district'=> 'required',
        'city'=> 'required',
        'uf'=> 'required',
        'cell_phone'=> 'required',
        'church_relationship'=> 'required',
        'entry_date'=> 'required',
        'hou_meet'=> 'required',
        'baptized'=> 'required',
        'accepted_jesus'=> 'required',
        'leader'=> 'required',
        'pastor'=> 'required',
        'Schooling'=> 'required',
        'profession'=> 'required',
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

    public function store(array $data): Profile | bool
    {
        // $this->validateForm($data);

        $getData = $this->find();
        if ($getData == null) {
            $data['user_id'] = Auth::user()->id;
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
