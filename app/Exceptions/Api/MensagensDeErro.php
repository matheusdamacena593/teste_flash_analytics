<?php

namespace App\Exceptions\Api;

class MensagensDeErro
{
    const RECURSO_NAO_ENCONTRADO = [
        'PRODUTO_NAO_ENCONTRADO' => [
            'mensagem' => 'Produto não encontrado',
            'descricao' => 'Nenhum produto foi encontrado com o id fornecido.',
            'status' => 404,
        ],
        'PEDIDO_NAO_ENCONTRADO' => [
            'mensagem' => 'Pedido não encontrado',
            'descricao' => 'Nenhum produto foi encontrado com o id fornecido.',
            'status' => 404,
        ],
    ];

    const ERRO_CADASTRAR_OU_ALTERAR = [
        'ERRO_CADASTRAR_PRODUTO' => [
            'mensagem' => 'Erro ao cadastrar produto',
            'descricao' => 'Não foi possivel cadastrar o produto.',
            'status' => 500,
        ],
        'ERRO_ALTERAR_PRODUTO' => [
            'mensagem' => 'Erro ao alterar produto',
            'descricao' => 'Não foi possivel alterar o produto.',
            'status' => 500,
        ],
        'ERRO_CADASTRAR_PEDIDO' => [
            'mensagem' => 'Erro ao cadastrar pedido',
            'descricao' => 'Não foi possivel cadastrar o pedido.',
            'status' => 500,
        ],
        'ERRO_ALTERAR_PEDIDO' => [
            'mensagem' => 'Erro ao alterar pedido',
            'descricao' => 'Não foi possivel alterar o pedido.',
            'status' => 500,
        ],
        'ERRO_DELETAR_PEDIDO' => [
            'mensagem' => 'Erro ao deletar pedido',
            'descricao' => 'Não foi possivel deletar o pedido.',
            'status' => 500,
        ],
        'ERRO_DELETAR_PRODUTO' => [
            'mensagem' => 'Erro ao deletar produto',
            'descricao' => 'Não foi possivel deletar o produto.',
            'status' => 500,
        ],
    ];

    const ERRO_NO_ESTOQUE = [
        'FALTA_ESTOQUE' => [
            'mensagem' => 'Erro ao retirar do estoque',
            'descricao' => 'O estoque não tem a quantidade buscada.',
            'status' => 500,
        ]
    ];

    const ERRO_INTERNO = [
        'ERRO_DESCONHECIDO' => [
            'mensagem' => 'Erro interno no servidor',
            'descricao' => 'Ocorreu um erro inesperado. Por favor, tente novamente mais tarde.',
            'status' => 500,
        ],
    ];
}
