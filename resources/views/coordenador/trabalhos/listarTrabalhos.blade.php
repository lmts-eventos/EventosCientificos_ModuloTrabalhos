@extends('coordenador.detalhesEvento')

@section('menu')
    <!-- Trabalhos -->
    <div id="divListarTrabalhos" style="display: block">

      <div class="row ">
        <div class="col-sm-6">
            <h1 class="">Trabalhos</h1>
        </div> 
                  
        <div class="col-sm-3"></div>
        <div class="col-sm-3">
          <form method="GET" action="{{route('distribuicao')}}">
            <input type="hidden" name="eventoId" value="{{$evento->id}}">
            <button onclick="event.preventDefault();" data-toggle="modal" data-target="#modalDistribuicaoAutomatica" class="btn btn-primary" style="width:100%">
              {{ __('Distribuir trabalhos') }}
            </button>
          </form>

        </div>            
      </div>

    {{-- Tabela Trabalhos --}}
    <div class="row table-trabalhos">
      <div class="col-sm-12">
        
        <form action="{{route('atribuicao.check')}}" method="post">
          @csrf
          {{-- <div class="row">
            <div class="col-sm-9"></div>
            <div class="col-sm-3">
              <button type="submit" class="btn btn-primary" style="width:100%">
                {{ __('Distribuir em lote') }}
              </button>
            </div>
          </div> --}}
          <div class="row">
            <div class="col-sm-12">
              @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif 
            </div>            
          </div>
          
          <input type="hidden" name="eventoId" value="{{$evento->id}}">
          <br>
          <table class="table table-hover table-responsive-lg table-sm table-striped">
            <thead>
              <tr>
                <th scope="col" style="text-align:center">Check</th>
                <th scope="col">
                  Título
                  <a href="{{route('coord.listarTrabalhos',[ 'eventoId' => $evento->id, 'titulo', 'asc'])}}">
                    <i class="fas fa-arrow-alt-circle-up"></i> 
                  </a>
                  <a href="{{route('coord.listarTrabalhos',[ 'eventoId' => $evento->id, 'titulo', 'desc'])}}">
                    <i class="fas fa-arrow-alt-circle-down"></i>
                  </a>
                </th>
                <th scope="col">
                  Área
                  <a href="{{route('coord.listarTrabalhos',[ 'eventoId' => $evento->id, 'areaId', 'asc'])}}">
                    <i class="fas fa-arrow-alt-circle-up"></i>
                  </a>
                  <a href="{{route('coord.listarTrabalhos',[ 'eventoId' => $evento->id, 'areaId', 'desc'])}}">
                    <i class="fas fa-arrow-alt-circle-down"></i>
                  </a>
                </th>
                 <th scope="col">
                  Autor
                  <a href="{{route('coord.listarTrabalhos',[ 'eventoId' => $evento->id, 'autor', 'asc'])}}">
                    <i class="fas fa-arrow-alt-circle-up"></i>
                  </a>
                  <a href="{{route('coord.listarTrabalhos',[ 'eventoId' => $evento->id, 'autor', 'desc'])}}">
                    <i class="fas fa-arrow-alt-circle-down"></i>
                  </a>
                </th>
                <th scope="col" style="width:15%"> 
                  Modalidade
                  <a href="{{route('coord.listarTrabalhos',[ 'eventoId' => $evento->id, 'modalidadeId', 'asc'])}}">
                    <i class="fas fa-arrow-alt-circle-up"></i>
                  </a>
                  <a href="{{route('coord.listarTrabalhos',[ 'eventoId' => $evento->id, 'modalidadeId', 'desc'])}}">
                    <i class="fas fa-arrow-alt-circle-down"></i>
                  </a>
                </th>
                <th scope="col">
                  Revisores
                  {{-- <a href="{{route('coord.listarTrabalhos',[ 'eventoId' => $evento->id, 'areaId', 'desc'])}}">
                    <i class="fas fa-arrow-alt-circle-up"></i>
                  </a>
                  <a href="{{route('coord.listarTrabalhos',[ 'eventoId' => $evento->id, 'areaId', 'desc'])}}">
                    <i class="fas fa-arrow-alt-circle-down"></i>
                  </a> --}}
                </th>
                <th scope="col" style="text-align:center">Atribuir</th>
              </tr>
            </thead>
            
            <tbody>
              @php $i = 0; @endphp
              @foreach($trabalhos as $trabalho)
              
              <tr>
                  <td style="text-align:center">
                    <input type="checkbox" aria-label="Checkbox for following text input" name="id[]" value="{{$trabalho->id}}">                
                  </td>
                  <td>
                    @if ($trabalho->arquivo()->where('versaoFinal', true)->first() != null)
                      <a href="{{route('downloadTrabalho', ['id' => $trabalho->id, 'check' => 0])}}" target="_blank">
                        {{$trabalho->titulo}}
                      </a>
                      @if ($trabalho->arquivo()->where('versaoFinal', false)->first() != null)
                        <a href="{{route('downloadTrabalho', ['id' => $trabalho->id, 'check' => 1])}}" target="_blank" style="font-size: 20px; color: #114048ff;" title="Versão corrigida">
                          <img class="" src="{{asset('img/icons/file-download-solid-primary-color.svg')}}" style="width:18px">
                        </a>
                      @endif
                    @else
                      {{$trabalho->titulo}}
                    @endif
                  </td>
                  <td>{{$trabalho->area->nome}}</td>
                  <td>{{$trabalho->autor->name}}</td>
                  <td >{{$trabalho->modalidade->nome}}</td>
                  <td>
                    {{count($trabalho->atribuicoes)}}
                    {{-- @if (count($trabalho->atribuicoes) == 0)
                      Nenhum revisor atribuído
                    @elseif (count($trabalho->atribuicoes) == 1)
                      {{count($trabalho->atribuicoes)}}
                    @endif --}}
                  </td>
                  
                  <td style="text-align:center">
                    <a href="#" data-toggle="modal" data-target="#modalTrabalho{{$trabalho->id}}">
                      <i class="fas fa-file-alt"></i>
                    </a>
                    
                  </td>
                </tr>
              
              @endforeach
            </tbody>
          </table>
        </form>
      </div>
      
    </div>

</div>
<!-- End Trabalhos -->
<!-- Modal Trabalho -->
<div class="modal fade" id="modalDistribuicaoAutomatica" tabindex="-1" role="dialog" aria-labelledby="modalDistribuicaoAutomatica" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #114048ff; color: white;">
        <h5 class="modal-title" id="exampleModalCenterTitle">Distrbuir trabalhos automaticamente</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="GET" action="{{ route('distribuicaoAutomaticaPorArea') }}" id="formDistribuicaoPorArea">
        <div class="modal-body">
          <input type="hidden" name="eventoId" value="{{$evento->id}}">
          <div class="row">
            <div class="col-sm-12">
                <input type="hidden" name="distribuirTrabalhosAutomaticamente" value="{{$evento->id}}">
                <label for="areaId" class="col-form-label">{{ __('Área') }}</label>
                <select class="form-control @error('área') is-invalid @enderror" id="areaIdformDistribuicaoPorArea" name="área" required>
                    <option value="" disabled selected hidden>-- Área --</option>
                    @foreach($areas as $area)
                        <option value="{{$area->id}}">{{$area->nome}}</option>
                    @endforeach
                </select>

                @error('área')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
          </div>
          <div class="row">
              <div class="col-sm-12">
                  <label for="numeroDeRevisoresPorTrabalho" class="col-form-label">{{ __('Número de revisores por trabalho') }}</label>
              </div>
          </div>
          <div class="row justify-content-center">
              <div class="col-sm-12">
                  <input id="numeroDeRevisoresPorTrabalhoInput" type="number" min="1" class="form-control @error('numeroDeRevisoresPorTrabalho') is-invalid @enderror" name="numeroDeRevisoresPorTrabalho" value="{{ old('numeroDeRevisoresPorTrabalho') }}" required autocomplete="numeroDeRevisoresPorTrabalho" autofocus>

                  @error('numeroDeRevisoresPorTrabalho')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
                  @enderror
              </div>

          </div>{{-- end row--}}
        </div>
      </form>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <button id="numeroDeRevisoresPorTrabalhoButton" onclick="document.getElementById('formDistribuicaoPorArea').submit();" type="button" class="btn btn-primary">Distribuir</button>
      </div>
    </div>
  </div>
</div>

@foreach ($trabalhos as $trabalho)
    <!-- Modal Trabalho -->
  <div class="modal fade" id="modalTrabalho{{$trabalho->id}}" tabindex="-1" role="dialog" aria-labelledby="labelModalTrabalho{{$trabalho->id}}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header" style="background-color: #114048ff; color: white;">
          <h5 class="modal-title" id="exampleModalCenterTitle">Trabalho</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row justify-content-center">
            <div class="col-sm-12">
              <h5>Título</h5>
              <p id="tituloTrabalho">{{$trabalho->titulo}}</p>
            </div>

          </div>
          @if ($trabalho->resumo != "")
            <div class="row justify-content-center">
              <div class="col-sm-12">
                <h5>Resumo</h5>
                <p id="resumoTrabalho">{{$trabalho->resumo}}</p>
              </div>
            </div> 
          @endif
          @if (count($trabalho->atribuicoes) > 0)
            <div class="row justify-content-center">
              <div class="col-sm-12">
                <h5>Revisores atribuidos ao trabalho</h5>
              </div>
          @else
            <div class="row justify-content-center">
              <div class="col-sm-12">
                <h5>0</h5>
              </div>
          @endif
          @foreach ($trabalho->atribuicoes as $i => $revisor) 
            @if ($i % 3 == 0) </div><div class="row"> @endif
              <div class="col-sm-4">
                <div class="card" style="width: 13.5rem; text-align: center;">
                  <img class="" src="{{asset('img/icons/user.png')}}" width="100px" alt="Revisor" style="position: relative; left: 30%; top: 10px;">
                  <div class="card-body">
                    <h6 class="card-title">{{$revisor->user->name}}</h6>
                    <strong>E-mail</strong>
                    <p class="card-text">{{$revisor->user->email}}</p>
                    <form action="{{ route('atribuicao.delete', ['id' => $revisor->id]) }}" method="post">
                      @csrf
                      <input type="hidden" name="eventoId" value="{{$evento->id}}">
                      <input type="hidden" name="trabalho_id" value="{{$trabalho->id}}">
                      <button type="submit" class="btn btn-primary" id="removerRevisorTrabalho">Remover Revisor</button>
                    </form>
                  </div>
                </div>
              </div>
          @endforeach
          </div>
          <br>
          <div class="row">
            <div class="col-sm-12">
              <h5>Adicionar Revisor</h5>
            </div>
          </div>
          <form action="{{ route('distribuicaoManual') }}" method="post">
            @csrf
            <input type="hidden" name="trabalhoId" value="{{$trabalho->id}}">
            <input type="hidden" name="eventoId" value="{{$evento->id}}">
            <div class="row" >
              <div class="col-sm-9">
                <div class="form-group">
                  <select name="revisorId" class="form-control" id="selectRevisorTrabalho">
                    <option value="" disabled selected>-- E-mail do revisor --</option>
                    @foreach ($evento->revisors()->where([['modalidadeId', $trabalho->modalidade->id], ['areaId', $trabalho->area->id]])->get() as $revisor)
                      @if (!$trabalho->atribuicoes->contains($revisor))
                        <option value="{{$revisor->id}}">{{$revisor->user->email}}</option>
                      @endif
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-sm-3">
                <button type="submit" class="btn btn-primary" id="addRevisorTrabalho">Adicionar Revisor</button>
              </div>
          </form>
          </div>
          </div>
        <div class="modal-footer">


        </div>
      </div>
    </div>
  </div>
@endforeach
@endsection

