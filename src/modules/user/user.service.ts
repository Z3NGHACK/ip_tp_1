import { BadRequestException, Injectable, NotFoundException } from '@nestjs/common';
import { User } from './user.entity';
import { Repository } from 'typeorm';
import { InjectRepository } from '@nestjs/typeorm';

@Injectable()
export class UserService {
  constructor(
    @InjectRepository(User)
    private usersRepo: Repository<User>,
  ) {}

  async create(userData: Partial<User>) {
    try{
      const check = await this.usersRepo.findOne({where:{id: userData.id}})
      if(check)
        throw new NotFoundException(`User with id ${userData.id} already use`);

      const user = this.usersRepo.create(userData);
      return this.usersRepo.save(user);
    
    }catch(err){
      throw new BadRequestException(err.message)
    }
  }

  findAll() {
    try{
      return this.usersRepo.find({ relations: ['tasks'] });
    
    }catch(err){
      throw new BadRequestException(err.message)
    }
  }

  findOne(id: number) {
    try{
      const user = this.usersRepo.findOne({where:{id: id}})
      if(!user)
        throw new NotFoundException(`User with id ${id} not found`);
      return this.usersRepo.findOne({ where: { id }, relations: ['tasks'] });
    
    }catch(err){
      throw new BadRequestException(err.message)
    }
  }

  async update(id: number, updateData: Partial<User>) {
    try{
      await this.usersRepo.update(id, updateData);
      return this.findOne(id);
    }catch(err){
      throw new BadRequestException(err.message)
    }
  }

  remove(id: number) {
    return this.usersRepo.delete(id);
  }
}