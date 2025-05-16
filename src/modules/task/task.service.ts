import { Injectable } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { Task } from './task.entity';

@Injectable()
export class TaskService {
  constructor(
    @InjectRepository(Task)
    private tasksRepo: Repository<Task>,
  ) {}
  // Get a task by ID
  async getAllTask(): Promise<any> {
    return this.tasksRepo.find({
      relations: ['user'], // load related user if needed
    });
  }

  // Get a task by ID
  async getTask(id: number): Promise<Task | null> {
    return this.tasksRepo.findOne({
      where: { id },
      relations: ['user'], // load related user if needed
    });
  }

  // Create a new task
  async createTask(taskData: Partial<Task>): Promise<Task> {
    const task = this.tasksRepo.create(taskData);
    return this.tasksRepo.save(task);
  }

  // Update an existing task by ID
  async updateTask(id: number, updateData: Partial<Task>): Promise<Task | null> {
    await this.tasksRepo.update(id, updateData);
    return this.getTask(id);
  }

  // Delete a task by ID
  async deleteTask(id: number): Promise<{ message: string }> {
    await this.tasksRepo.delete(id);
    return { message: 'success' };
  }
}
