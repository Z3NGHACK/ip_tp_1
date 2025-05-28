import { BadRequestException, Injectable, NotFoundException } from '@nestjs/common';
import { InjectRepository } from '@nestjs/typeorm';
import { Repository } from 'typeorm';
import { Task } from './task.entity';
import { User } from '../user/user.entity';

@Injectable()
export class TaskService {
  private tasks: any = [];
  private users: any  = [];
  constructor(
    @InjectRepository(Task)
    private tasksRepo: Repository<Task>,
    
    @InjectRepository(User)
    private usersRepo: Repository<User>,
  ) {}
  // Get a task by ID
  async getAllTask(): Promise<any> {
    return this.tasksRepo.find({
      relations: ['userId'], // load related user if needed
    });
  }

  // Get a task by ID
  async getTask(id: number): Promise<Task | null> {
    const task = this.tasks.find(t => t.id === id);
    if (!task) {
      throw new NotFoundException(`Task with id ${id} not found`);
    }
    return task;
  }

  // Create a new task
  async createTask(taskData: Partial<any>): Promise<Task> {
    const userExists = await this.usersRepo.findOne({
      where: {id: taskData.userId}
    })
    if (!userExists) {
      throw new BadRequestException(`User with id ${taskData.userId} does not exist`);
    }
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
