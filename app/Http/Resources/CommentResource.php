<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
          'id' => $this->id,
          'post_id' => $this->post_id,
          'post_title' => $this->posted->title,
          'comments_content' => $this->comments_content,
          'user_id' => $this->user_id,
          'user_name' => $this->commentator->username,
        //   'commentator' => $this->whenLoaded('commentator'),
          'created_at' => date_format($this->created_at, "Y-m-d H:i:s")
        ];
    }
}
