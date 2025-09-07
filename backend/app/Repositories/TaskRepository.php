<?php 

// app/Repositories/TaskRepository.php
interface TaskRepositoryInterface {
    public function forUser(int $userId): LengthAwarePaginator|Collection;
    public function findOwned(int $userId,int $id): ?Task;
    public function create(array $data): Task;
    public function update(Task $task,array $data): Task;
    public function delete(Task $task): void;
}


class TaskRepository implements TaskRepositoryInterface
{
    public function forUser(int $userId){ return Task::where('user_id',$userId)->latest()->paginate(20); }
    public function findOwned(int $userId,int $id){ return Task::where('user_id',$userId)->find($id); }
    public function create(array $data){ return Task::create($data); }
    public function update(Task $task,array $data){ $task->update($data); return $task; }
    public function delete(Task $task){ $task->delete(); }
}