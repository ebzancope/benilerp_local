
<?php
// app/Http/Middleware/LogUserActions.php

//namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogUserActions
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Log apenas para métodos POST, PUT, PATCH, DELETE
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            $this->logAction($request);
        }

        return $response;
    }

    private function logAction(Request $request)
    {
        $user =  session('user.id');

        if (!$user) return;

        $action = $this->getActionType($request->method());
        $table = $this->getTableName($request->route());
        $recordId = $this->getRecordId($request);

        DB::table('user_actions')->insert([
            'user_id' => $user->id,
            'action' => $action,
            'table_name' => $table,
            'record_id' => $recordId,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    private function getActionType($method)
    {
        return match ($method) {
            'POST' => 'create',
            'PUT', 'PATCH' => 'update',
            'DELETE' => 'delete',
            default => 'other'
        };
    }

    private function getTableName($route)
    {
        // Implementar lógica para extrair nome da tabela da rota
        return $route->getName() ?? 'unknown';
    }

    private function getRecordId($request)
    {
        return $request->route('id') ?? $request->input('id') ?? null;
    }
}
