<?php 

namespace App\Entity\Employee;

class Employee
{
    private ?int $id_employee = null;
    private string $name_employee;

    private string $lastname_employee;
    private string $email_employee;
    private ?string $password = null;
    private \DateTime $date_hire_employee;

    private int $id_role;



    public function __construct(
        string $name_employee,
        string $lastname_employee,
        string $email_employee,
        ?string $password,
        \DateTime $date_hire_employee,
        int $id_role
    ) {
        $this->name_employee = $name_employee;
        $this->lastname_employee = $lastname_employee;
        $this->email_employee = $email_employee;
        $this->password = $password;
        $this->date_hire_employee = $date_hire_employee;
        $this->id_role = $id_role;
    }

    //GETTERS & SETTERS



    /**
     * Get the value of id_employee
     */
    public function getIdEmployee(): ?int
    {
        return $this->id_employee;
    }

    /**
     * Set the value of id_employee
     */
    public function setIdEmployee(?int $id_employee): self
    {
        $this->id_employee = $id_employee;

        return $this;
    }

    /**
     * Get the value of name_employee
     */
    public function getNameEmployee(): string
    {
        return $this->name_employee;
    }

    /**
     * Set the value of name_employee
     */
    public function setNameEmployee(string $name_employee): self
    {
        $this->name_employee = $name_employee;

        return $this;
    }

    /**
     * Get the value of lastname_employee
     */
    public function getLastnameEmployee(): string
    {
        return $this->lastname_employee;
    }

    /**
     * Set the value of lastname_employee
     */
    public function setLastnameEmployee(string $lastname_employee): self
    {
        $this->lastname_employee = $lastname_employee;

        return $this;
    }

    /**
     * Get the value of email_employee
     */
    public function getEmailEmployee(): string
    {
        return $this->email_employee;
    }

    /**
     * Set the value of email_employee
     */
    public function setEmailEmployee(string $email_employee): self
    {
        $this->email_employee = $email_employee;

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
     * Get the value of date_hire_employee
     */
    public function getDateHireEmployee(): \DateTime
    {
        return $this->date_hire_employee;
    }

    /**
     * Set the value of date_hire_employee
     */
    public function setDateHireEmployee(\DateTime $date_hire_employee): self
    {
        $this->date_hire_employee = $date_hire_employee;

        return $this;
    }

    /**
     * Get the value of id_role
     */
    public function getIdRole(): int
    {
        return $this->id_role;
    }

    /**
     * Set the value of id_role
     */
    public function setIdRole(int $id_role): self
    {
        $this->id_role = $id_role;

        return $this;
    }
}