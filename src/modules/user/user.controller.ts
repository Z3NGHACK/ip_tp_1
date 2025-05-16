import {
  Get,
  Param,
  Controller,
  Post,
  Body,
  Patch,
  Delete,
} from '@nestjs/common';
import { UserService } from './user.service';

@Controller('users')
export class UsersController {
  constructor(private readonly userService: UserService) {}

  // Get user by ID
  @Get('/:id')
  getUser(@Param('id') id: string) {
    return this.userService.findOne(+id); // convert id string to number
  }

  // Create new user
  @Post()
  createUser(
    @Body() body: { username: string; email: string; password: string },
  ) {
    return this.userService.create(body);
  }

  // Update user by ID
  @Patch('/:id')
  updateUser(
    @Param('id') id: string,
    @Body() body: { username?: string; email?: string; password?: string },
  ) {
    return this.userService.update(+id, body);
  }

  // Delete user by ID
  @Delete('/:id')
  deleteUser(@Param('id') id: string) {
    return this.userService.remove(+id);
  }
}
