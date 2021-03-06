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

    $class['limite_orcamentario'] = $route->getName() == 'loa.index' ? 'active' : '';
    $class['certidao_credito'] = $route->getName() == 'credito_planejado.index' ? 'active' : '';
@endphp
<nav class="nav nav-pills flex-column flex-sm-row">
    <a class="flex-sm-fill text-sm-center nav-link {{ $class['limite_orcamentario'] }}" aria-current="page" href="{{ route('loa.index', ['ploa' => $exercicio->id]) }}">Limites Orçamentários</a>
    <a class="flex-sm-fill text-sm-center nav-link {{ $class['certidao_credito'] }}" href="{{ route('credito_planejado.index', ['tipo' => 2, 'ploa' => $exercicio->id]) }}">Certidões de Crédito
        {{-- <sup><span class="badge rounded-pill bg-danger">*</span></sup> --}}
    </a>
    <a class="flex-sm-fill text-sm-center nav-link" href="#">Empenhos</a>
    <a class="flex-sm-fill text-sm-center nav-link" href="#">Remanejamentos</a>
  </nav>