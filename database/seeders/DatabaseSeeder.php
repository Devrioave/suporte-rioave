<?php

namespace Database\Seeders;

use App\Models\Solicitacao;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@rioave.com.br'],
            [
                'name' => 'Administrador Rio Ave',
                'password' => bcrypt('rioave@2026'),
                'email_verified_at' => now(),
            ]
        );

        User::query()->updateOrCreate(
            ['email' => 'suporte@rioave.com.br'],
            [
                'name' => 'Equipe de Suporte',
                'password' => bcrypt('rioave@2026'),
                'email_verified_at' => now(),
            ]
        );

        $targetTotal = 60;
        $existingTotal = Solicitacao::count();
        if ($existingTotal >= $targetTotal) {
            return;
        }

        $statusList = ['novo', 'pendente', 'em_andamento', 'resolvido'];
        $motivos = ['suporte', 'duvida', 'solicitacao', 'outro'];
        $prioridades = ['baixa', 'media', 'alta', 'urgente'];
        $nomes = [
            'Ana Martins', 'Carlos Silva', 'Fernanda Costa', 'Marcos Lima', 'Paula Souza',
            'Joao Alves', 'Patricia Gomes', 'Rafael Pereira', 'Bruna Rocha', 'Eduardo Santos',
            'Juliana Oliveira', 'Thiago Ribeiro', 'Camila Freitas', 'Gabriel Araujo', 'Larissa Melo',
        ];

        $rows = [];
        $missing = $targetTotal - $existingTotal;

        for ($i = 0; $i < $missing; $i++) {
            $nome = $nomes[array_rand($nomes)];
            $status = $statusList[array_rand($statusList)];
            $motivo = $motivos[array_rand($motivos)];
            $prioridade = $prioridades[array_rand($prioridades)];

            $createdAt = now()->subDays(rand(0, 35))->subHours(rand(0, 23))->subMinutes(rand(0, 59));
            $resolvidoEm = null;
            $respostaAdmin = null;

            if ($status === 'resolvido') {
                $resolvidoEm = (clone $createdAt)->addHours(rand(2, 96));
                if ($resolvidoEm->greaterThan(now())) {
                    $resolvidoEm = now()->subMinutes(rand(5, 180));
                }
                $respostaAdmin = 'Chamado resolvido com orientacao tecnica e confirmacao do solicitante.';
            } elseif ($status === 'em_andamento') {
                $respostaAdmin = 'Analise iniciada pela equipe tecnica. Retorno em andamento.';
            } elseif ($status === 'pendente') {
                $respostaAdmin = 'Aguardando retorno do solicitante para concluir o atendimento.';
            }

            $rows[] = [
                'protocolo' => $this->generateUniqueProtocol(),
                'nome_solicitante' => $nome,
                'telefone_solicitante' => sprintf('(81) 9%04d-%04d', rand(1000, 9999), rand(1000, 9999)),
                'email_solicitante' => Str::slug($nome, '.') . rand(1, 99) . '@cliente.com',
                'motivo_contato' => $motivo,
                'descricao_duvida' => 'Solicitacao de teste para validacao visual do painel administrativo e fluxo de atendimento.',
                'arquivo_anexo' => null,
                'status' => $status,
                'prioridade' => $prioridade,
                'resposta_admin' => $respostaAdmin,
                'resolvido_em' => $resolvidoEm,
                'created_at' => $createdAt,
                'updated_at' => now(),
            ];
        }

        DB::table('solicitacaos')->insert($rows);
    }

    private function generateUniqueProtocol(): string
    {
        do {
            $protocol = now()->format('Ymd') . '-' . strtoupper(Str::random(6));
        } while (DB::table('solicitacaos')->where('protocolo', $protocol)->exists());

        return $protocol;
    }
}

