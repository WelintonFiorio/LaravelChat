<?php

namespace App\Message;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Message extends Model
{
    // Definir a tabela associada ao modelo

    protected $table = 'messages';

    // Campos que podem ser preenchidos
    protected $fillable = ['content', 'sender_id' ];

    // Definir relacionamento com o modelo User
    public function sender(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Obtém o ID da mensagem.
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Obtém o conteúdo da mensagem.
     *
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Obtém o timestamp da mensagem.
     *
     * @return \Illuminate\Support\Carbon
     */
    public function getTimestamp(): \Illuminate\Support\Carbon
    {
        return $this->created_at; // Utiliza o timestamp do Eloquent
    }

    /**
     * Obtém o remetente da mensagem.
     *
     * @return User
     */
    public function getSender(): User
    {
        return $this->sender; // Relacionamento Eloquent
    }
}
