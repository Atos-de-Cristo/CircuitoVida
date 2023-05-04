<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Builder;
use App\Http\Livewire\Table;
use App\Models\Permission;
use App\Models\User;
use App\Table\Column;

class UsersTable extends Table
{
    public function query(): Builder
    {
        return User::query();
    }

    public function columns(): array
    {
        return [
            Column::make('id', '#'),
            Column::make('name', 'Name'),
            Column::make('email', 'Email'),
            Column::make('status', 'Status')->component('columns.users.status'),
            Column::make('created_at', 'Created At')->component('columns.human-diff'),
            Column::make('id', 'Actions')->component('columns.users.actions'),
        ];
    }
}
