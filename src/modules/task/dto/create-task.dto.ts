// src/task/dto/create-task.dto.ts
import { PartialType } from '@nestjs/mapped-types';
import { IsEmail, IsInt, IsNotEmpty, IsOptional, IsString, MinLength } from 'class-validator';

export class CreateTaskDto {
  @IsNotEmpty()
  @IsString()
  name: string;

  @IsOptional()
  @IsString()
  description?: string;

  @IsInt()
  userId: number;
}
export class UpdateTaskDto extends PartialType(CreateTaskDto) {}