<?php

namespace App\Models;

use App\Message\Message;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;

    // Definindo o nome da tabela que o modelo representa
    protected $table = 'chat_rooms';

    // Campos que podem ser preenchidos em massa
    protected $fillable = ['name', 'is_group']; // Defina aqui os campos relevantes da tabela `chat_rooms`

    /**
     * Relacionamento muitos-para-muitos com o modelo User.
     *
     * Este método define a relação entre a sala de chat e os usuários associados.
     * A tabela de relacionamento `chat_room_user` é usada para associar múltiplos
     * usuários a uma sala de chat.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'chat_room_user'); // Altere se necessário
    }

    /**
     * Relacionamento um-para-muitos com o modelo Message.
     *
     * Este método define a relação entre a sala de chat e as mensagens associadas.
     * Cada sala de chat pode ter várias mensagens associadas a ela.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'chat_room_id');
    }
}
