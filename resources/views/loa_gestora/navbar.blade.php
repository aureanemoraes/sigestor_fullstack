@php
    $route = Route::current();
    // dd($route);

    $name = $route->getName();
    // dd($name);

    // $actionName = $route->getActionName();
    // dd($actionName);

    // $name = Route::currentRouteName();
    // dd($name);

    // $action = Route::currentRouteAction();
    // dd($action);

    $class['limite_orcamentario'] = $route->getName() == 'loa_gestora.index' ? 'active' : '';
    $class['certidao_credito'] = $route->getName() == 'credito_planejado.index' ? 'active' : '';
    $class['empenho'] = $route->getName() == 'empenho.index' ? 'active' : '';
    $class['remanejamento'] = $route->getName() == 'remanejamento.index' ? 'active' : '';
@endphp
<nav class="nav nav-pills flex-column flex-sm-row">
    <a class="flex-sm-fill text-sm-center nav-link {{ $class['limite_orcamentario'] }}" aria-current="page" href="{{ route('loa_gestora.index', ['ploa' => $exercicio->id, 'unidade_gestora' => $unidade_selecionada->id]) }}">Limites Orçamentários</a>
    <a class="flex-sm-fill text-sm-center nav-link {{ $class['certidao_credito'] }}" href="{{ route('credito_planejado.index', ['tipo' => 1, 'ploa' => $exercicio->id, 'unidade_gestora' => $unidade_selecionada->id]) }}">Certidões de Crédito
        {{-- <sup><span class="badge rounded-pill bg-danger">*</span></sup> --}}
    </a>
    <a class="flex-sm-fill text-sm-center nav-link {{ $class['empenho'] }}" href="{{ route('empenho.index', ['ploa' => $exercicio->id, 'unidade_gestora' => $unidade_selecionada->id]) }}">Empenhos</a>
    <a class="flex-sm-fill text-sm-center nav-link {{ $class['remanejamento'] }}" href="{{ route('remanejamento.index', ['ploa' => $exercicio->id, 'unidade_gestora' => $unidade_selecionada->id]) }}">Remanejamentos</a>
  </nav>