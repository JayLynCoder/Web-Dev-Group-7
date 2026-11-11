<?php

namespace App\Services;

use Kreait\Firebase\Contract\Database;

class UserStore
{
    public const ROLES = ['superadmin', 'admin', 'student'];

    public function __construct(protected Database $database)
    {
    }

    /** All users as objects, in the order they were created. */
    public function all(): array
    {
        $data = $this->database->getReference('users')->getValue() ?? [];

        $users = [];
        foreach ($data as $id => $user) {
            $users[] = $this->toObject((string) $id, $user);
        }

        return $users;
    }

    public function find(string $id): ?object
    {
        if (! preg_match('/^[A-Za-z0-9\-_]+$/', $id)) {
            return null;
        }

        $data = $this->database->getReference("users/{$id}")->getValue();

        return $data ? $this->toObject($id, $data) : null;
    }

    public function findByEmail(string $email): ?object
    {
        $email = strtolower($email);

        foreach ($this->all() as $user) {
            if (strtolower($user->email) === $email) {
                return $user;
            }
        }

        return null;
    }

    public function usernameExists(string $username, ?string $exceptId = null): bool
    {
        $username = strtolower($username);

        foreach ($this->all() as $user) {
            if ($exceptId !== null && $user->id === $exceptId) {
                continue;
            }

            if (strtolower($user->username) === $username) {
                return true;
            }
        }

        return false;
    }

    public function emailExists(string $email, ?string $exceptId = null): bool
    {
        $email = strtolower($email);

        foreach ($this->all() as $user) {
            if ($exceptId !== null && $user->id === $exceptId) {
                continue;
            }

            if (strtolower($user->email) === $email) {
                return true;
            }
        }

        return false;
    }

    public function studentLinked(string $studentNumber, ?string $exceptId = null): bool
    {
        foreach ($this->all() as $user) {
            if ($exceptId !== null && $user->id === $exceptId) {
                continue;
            }

            if ($user->student_id !== null && (string) $user->student_id === $studentNumber) {
                return true;
            }
        }

        return false;
    }

    /** Creates a user and returns its id. */
    public function create(array $data): string
    {
        $role = $data['role'] ?? (! empty($data['is_admin']) ? 'admin' : 'student');

        if (! in_array($role, self::ROLES, true)) {
            $role = 'student';
        }

        $ref = $this->database->getReference('users')->push([
            'username'      => $data['username'],
            'full_name'     => $data['full_name'],
            'email'         => strtolower($data['email']),
            'password_hash' => $data['password_hash'],
            'role'          => $role,
            'is_admin'      => in_array($role, ['superadmin', 'admin'], true),
            'student_id'    => $data['student_id'] ?? '',
            'created_at'    => now()->toDateTimeString(),
        ]);

        return (string) $ref->getKey();
    }

    /** Updates an existing user. Leave password_hash out to keep the old password. */
    public function update(string $id, array $data): void
    {
        $role = $data['role'] ?? 'student';

        if (! in_array($role, self::ROLES, true)) {
            $role = 'student';
        }

        $payload = [
            'username'   => $data['username'],
            'full_name'  => $data['full_name'],
            'email'      => strtolower($data['email']),
            'role'       => $role,
            'is_admin'   => in_array($role, ['superadmin', 'admin'], true),
            'student_id' => $data['student_id'] ?? '',
        ];

        if (! empty($data['password_hash'])) {
            $payload['password_hash'] = $data['password_hash'];
        }

        $this->database->getReference("users/{$id}")->update($payload);
    }

    public function delete(string $id): void
    {
        $this->database->getReference("users/{$id}")->remove();
    }

    private function toObject(string $id, array $data): object
    {
        $data = $data + [
            'username'      => '',
            'full_name'     => '',
            'email'         => '',
            'password_hash' => '',
            'role'          => null,
            'is_admin'      => false,
            'student_id'    => null,
            'created_at'    => null,
        ];

        // Accounts made before roles existed: work out the role from is_admin
        if (empty($data['role'])) {
            $data['role'] = $data['is_admin'] ? 'admin' : 'student';
        }

        $data['is_admin'] = in_array($data['role'], ['superadmin', 'admin'], true);

        // Empty string means "not linked to a student"
        if ($data['student_id'] === '') {
            $data['student_id'] = null;
        }

        $data['id'] = $id;

        return (object) $data;
    }
}