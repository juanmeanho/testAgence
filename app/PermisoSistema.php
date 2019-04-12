<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $co_usuario
 * @property integer $co_tipo_usuario
 * @property integer $co_sistema
 * @property string $in_ativo
 * @property string $co_usuario_atualizacao
 * @property string $dt_atualizacao
 */
class PermisoSistema extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'permissao_sistema';

    /**
     * @var array
     */
    protected $fillable = ['in_ativo', 'co_usuario_atualizacao', 'dt_atualizacao'];

}
