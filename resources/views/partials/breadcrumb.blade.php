@php
  $quantidade_itens = count($data);
  $contador = 0;
@endphp

<nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='currentColor'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
  <ol class="breadcrumb">
    @foreach($data as $key => $item)
      @if($contador == $quantidade_itens - 1)
        <li class="breadcrumb-item" aria-current="page">{{ $item['nome'] }}</li>
      @else
        <li class="breadcrumb-item"><a href="{{ route($item['rota'], $item['parametros']) }}">{{ $item['nome'] }}</a></li>
      @endif
      @php
        $contador++;
      @endphp
    @endforeach
  </ol>
</nav>