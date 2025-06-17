<?php
namespace App;

class Submission
{
    /**
     * @var array<string,array{completo:string,tiempo:float,errores:string,notas:string}>
     */
    private array $data;

    /**
     * @param array<string,array> $data  Estructura interna de un envío
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Construye un Submission a partir del $_POST de form.php
     *
     * @param array<string,mixed> $post
     */
    public static function fromPost(array $post): Submission
    {
        $data = [];
        foreach (Config::FUNCS as $code => $_label) {
            $data[$code] = [
                'completo' => $post['completo'][$code] ?? '',
                'tiempo'   => floatval($post['tiempo'][$code]   ?? 0),
                'errores'  => $post['errores'][$code]  ?? '',
                'notas'    => $post['notas'][$code]    ?? '',
            ];
        }
        return new self($data);
    }

    /**
     * Devuelve la representación en array para serializar a JSON
     *
     * @return array<string,array>
     */
    public function toArray(): array
    {
        return $this->data;
    }
}
