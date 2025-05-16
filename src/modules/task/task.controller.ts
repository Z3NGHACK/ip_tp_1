import {
  Body,
  Controller,
  Delete,
  Get,
  Param,
  Patch,
  Post,
} from '@nestjs/common';
import { TaskService } from './task.service';

@Controller('tasks')
export class TasksController {
  constructor(private readonly taskService: TaskService) {}

  @Get('/')
  async getAllTask() {
    return await this.taskService.getAllTask();
  }
  @Get('/:id')
  async getTask(@Param('id') id: string) {
    return await this.taskService.getTask(+id);
  }

  @Post()
  async createTask(@Body() body: any) {
    return await this.taskService.createTask(body);
  }

  // Mark task as done: set completedAt to current date/time
  @Patch('/:id/done')
  async markTaskAsDone(@Param('id') id: string) {
    return await this.taskService.updateTask(+id, { completedAt: new Date() });
  }

  // Mark task as pending: set completedAt to null
  @Patch('/:id/pending')
  async markTaskAsPending(@Param('id') id: string) {
    return await this.taskService.updateTask(+id, { completedAt: null });
  }

  @Delete('/:id')
  async deleteTask(@Param('id') id: string) {
    return await this.taskService.deleteTask(+id);
  }
}
