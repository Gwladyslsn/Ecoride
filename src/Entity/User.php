<?php

namespace App\Entity;

class User
{
    public function __construct(
        private ?int $id,
        private string $name,
        private string $lastname,
        private string $email,
        private ?string $password = null,
        private ?int $roleId = null,
        private ?string $avatar = null,
    ) {}

    

        /**
         * Get the value of id
         */
        public function getId(): ?int
        {
                return $this->id;
        }

        /**
         * Set the value of id
         */
        public function setId(?int $id): self
        {
                $this->id = $id;
                return $this;
        }

        /**
         * Get the value of name
         */
        public function getName(): string
        {
                return $this->name;
        }

        /**
         * Set the value of name
         */
        public function setName(string $name): self
        {
                $this->name = $name;
                return $this;
        }

        /**
         * Get the value of lastname
         */
        public function getLastname(): string
        {
                return $this->lastname;
        }

        /**
         * Set the value of lastname
         */
        public function setLastname(string $lastname): self
        {
                $this->lastname = $lastname;
                return $this;
        }

        /**
         * Get the value of email
         */
        public function getEmail(): string
        {
                return $this->email;
        }

        /**
         * Set the value of email
         */
        public function setEmail(string $email): self
        {
                $this->email = $email;
                return $this;
        }

        /**
         * Get the value of password
         */
        public function getPassword(): ?string
        {
                return $this->password;
        }

        /**
         * Set the value of password
         */
        public function setPassword(?string $password): self
        {
                $this->password = $password;
                return $this;
        }

        /**
         * Get the value of roleId
         */
        public function getRoleId(): ?int
        {
                return $this->roleId;
        }

        /**
         * Set the value of roleId
         */
        public function setRoleId(?int $roleId): self
        {
                $this->roleId = $roleId;
                return $this;
        }

        /**
         * Get the value of avatar
         */
        public function getAvatar(): ?string
        {
                return $this->avatar;
        }

        /**
         * Set the value of avatar
         */
        public function setAvatar(?string $avatar): self
        {
                $this->avatar = $avatar;
                return $this;
        }
}
