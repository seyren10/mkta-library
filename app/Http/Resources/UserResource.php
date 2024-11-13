<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data =  parent::toArray($request);
        $data['roles'] = $this->whenLoaded('roles', function () {
            if ($this->roles->isNotEmpty()) {
                return $this->roles->map(function ($role) {
                    return [
                        'id' => $role->id,
                        'name' => $role->name
                    ];
                });
            }
        });
        $data['rolePermissions'] = $this->whenLoaded('roles', function () {
            if ($this->roles->isNotEmpty()) {
                return $this->roles->flatMap(function ($role) {
                    return $role->permissions->map(function ($permission) {
                        return [
                            'id' => $permission->id,
                            'name' => $permission->name
                        ];
                    });
                });
            }
        });
        
        return $data;
    }
}
