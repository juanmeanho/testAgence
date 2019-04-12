<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $co_usuario
 * @property string $no_usuario
 * @property string $ds_senha
 * @property string $co_usuario_autorizacao
 * @property integer $nu_matricula
 * @property string $dt_nascimento
 * @property string $dt_admissao_empresa
 * @property string $dt_desligamento
 * @property string $dt_inclusao
 * @property string $dt_expiracao
 * @property string $nu_cpf
 * @property string $nu_rg
 * @property string $no_orgao_emissor
 * @property string $uf_orgao_emissor
 * @property string $ds_endereco
 * @property string $no_email
 * @property string $no_email_pessoal
 * @property string $nu_telefone
 * @property string $dt_alteracao
 * @property string $url_foto
 * @property string $instant_messenger
 * @property int $icq
 * @property string $msn
 * @property string $yms
 * @property string $ds_comp_end
 * @property string $ds_bairro
 * @property string $nu_cep
 * @property string $no_cidade
 * @property string $uf_cidade
 * @property string $dt_expedicao
 * @property CaoConhecimento[] $caoConhecimentos
 * @property CaoHistOcorrenciasO[] $caoHistOcorrenciasOs
 * @property CaoPermissao[] $caoPermissaos
 */
class User extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'cao_usuario';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'co_usuario';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['no_usuario', 'ds_senha', 'co_usuario_autorizacao', 'nu_matricula', 'dt_nascimento', 'dt_admissao_empresa', 'dt_desligamento', 'dt_inclusao', 'dt_expiracao', 'nu_cpf', 'nu_rg', 'no_orgao_emissor', 'uf_orgao_emissor', 'ds_endereco', 'no_email', 'no_email_pessoal', 'nu_telefone', 'dt_alteracao', 'url_foto', 'instant_messenger', 'icq', 'msn', 'yms', 'ds_comp_end', 'ds_bairro', 'nu_cep', 'no_cidade', 'uf_cidade', 'dt_expedicao'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function caoConhecimentos()
    {
        return $this->hasMany('App\CaoConhecimento', 'usuario', 'co_usuario');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function caoHistOcorrenciasOs()
    {
        return $this->hasMany('App\CaoHistOcorrenciasO', 'co_usuario', 'co_usuario');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function caoPermissaos()
    {
        return $this->hasMany('App\CaoPermissao', 'co_usuario', 'co_usuario');
    }
}
