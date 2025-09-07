<?php

class TaskService
{
    public function __construct(private TaskRepositoryInterface $repo){}


    public function listFor(User $user){ return $this->repo->forUser($user->id); }
    public function getOwned(User $user,int $id){ return $this->repo->findOwned($user->id,$id); }

    public function createFor(User $user,array $data){
        $data['user_id'] = $user->id;
        if(($data['status'] ?? null) === 'done' && empty($data['completed_at']))
            $data['completed_at'] = now();
            return $this->repo->create($data);
    }


    public function updateOwned(Task $task,array $data){
        if(($data['status'] ?? null) === 'done' && empty($data['completed_at']))
        $data['completed_at'] = now();
        return $this->repo->update($task,$data);
    }


    public function deleteOwned(Task $task){ $this->repo->delete($task); }
}