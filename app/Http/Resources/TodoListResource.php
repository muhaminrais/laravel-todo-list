<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TodoListResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    // return parent::toArray($request);

    return [
      'id' => $this->id,
      'user_id' => $this->user_id,
      'name' => $this->name,
      'work' => $this->work,
      'duedate' => $this->duedate,
      'user' => [
        'id' => $this->user->id,
        'name' => $this->user->name,
        'username' => $this->user->username,
        'email' => $this->user->email,
      ],
    ];
  }
}
