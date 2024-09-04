<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Friendship
 *
 * Esta classe representa uma amizade entre dois usuários no sistema. A tabela associada é `friendships`,
 * que armazena informações sobre quem adicionou quem como amigo e o status dessa amizade.
 *
 * @package App\Models
 */
class Friendship extends Model
{
    /**
     * A tabela associada ao modelo.
     *
     * @var string
     */
    protected $table = 'friendships';

    /**
     * Os atributos que podem ser preenchidos em massa.
     *
     * Estes atributos definem quais campos da tabela podem ser atribuídos em massa ao criar ou atualizar
     * uma instância do modelo.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'friend_id', 'status'];

    /**
     * Obter o ID do usuário que iniciou a amizade.
     *
     * Este método retorna o valor do atributo `user_id`, que representa o usuário que enviou a solicitação
     * de amizade.
     *
     * @return int|null O ID do usuário que iniciou a amizade, ou null se não estiver definido.
     */
    public function getUserIdAttribute(): ?int
    {
        return $this->attributes['user_id'] ?? null;
    }

    /**
     * Definir o ID do usuário que iniciou a amizade.
     *
     * Este método permite definir o valor do atributo `user_id`, que representa o usuário que enviou a
     * solicitação de amizade.
     *
     * @param int|null $userId O ID do usuário que está iniciando a amizade.
     * @return void
     */
    public function setUserIdAttribute(?int $userId): void
    {
        $this->attributes['user_id'] = $userId;
    }

    /**
     * Obter o ID do amigo na amizade.
     *
     * Este método retorna o valor do atributo `friend_id`, que representa o usuário que recebeu a solicitação
     * de amizade.
     *
     * @return int|null O ID do amigo, ou null se não estiver definido.
     */
    public function getFriendIdAttribute(): ?int
    {
        return $this->attributes['friend_id'] ?? null;
    }

    /**
     * Definir o ID do amigo na amizade.
     *
     * Este método permite definir o valor do atributo `friend_id`, que representa o usuário que recebeu a
     * solicitação de amizade.
     *
     * @param int|null $friendId O ID do amigo.
     * @return void
     */
    public function setFriendIdAttribute(?int $friendId): void
    {
        $this->attributes['friend_id'] = $friendId;
    }

    /**
     * Obter o status da amizade.
     *
     * Este método retorna o valor do atributo `status`, que indica o estado atual da amizade
     * (e.g., 'pending', 'accepted', 'rejected').
     *
     * @return string|null O status da amizade, ou null se não estiver definido.
     */
    public function getStatusAttribute(): ?string
    {
        return $this->attributes['status'] ?? null;
    }

    /**
     * Definir o status da amizade.
     *
     * Este método permite definir o valor do atributo `status`, que indica o estado atual da amizade.
     *
     * @param string|null $status O novo status da amizade.
     * @return void
     */
    public function setStatusAttribute(?string $status): void
    {
        $this->attributes['status'] = $status;
    }
}
