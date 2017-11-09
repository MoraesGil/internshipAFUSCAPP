<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
  <div class="menu_section">
    <ul class="nav side-menu">
      <li><a href="{{route('home')}}"><i class="fa fa-home fa-fw"></i>  Home </a></li>

      <li class="">
        <a><i class="fa fa-cubes fa-fw"></i> Financeiro <span class="fa fa-chevron-down fa-fw"></span></a>
        <ul class="nav child_menu" style="display: none;">
          <li><a href="{{route('mov.movimentacoes.index')}}">  Lançamentos </a></li>
          <li><a href="{{route('con.contas.index')}}">Gerenciar Contas </a></li>
          <li><a href="{{route('cat.categorias.index')}}">Gerenciar Categorias </a></li>
          <li><a href="#">   Gerar Contas a Receber </a></li>
          <li><a href="#">   Exportar folha descontos </a></li>
        </ul>
      </li>

      <li class="">
        <a><i class="fa fa-tag fa-fw"></i> Vales <span class="fa fa-chevron-down fa-fw"></span></a>
        <ul class="nav child_menu" style="display: none;">
          <li><a href="#">  Listar Vales </a></li>
          <li><a href="#">  Emitir Vale</a></li>
        </ul>
      </li>

      <li class="">
        <a><i class="fa fa-vcard-o fa-fw"></i> Associados <span class="fa fa-chevron-down fa-fw"></span></a>
        <ul class="nav child_menu" style="display: none;">
          <li><a href="{{route('ass.associados.index')}}">   Gerenciar Asssociados </a></li>
          <li><a href="#">   Gerar contas receber associado</a></li>
        </ul>
      </li>

      <li class="">
        <a><i class="fa fa-building-o fa-fw"></i> Convênios <span class="fa fa-chevron-down fa-fw"></span></a>
        <ul class="nav child_menu" style="display: none;">
          <li><a href="#">   Gerenciar Asssociados </a></li>
          <li><a href="#">   Gerar contas receber associado</a></li>
        </ul>
      </li>

      <li class="">
        <a><i class="fa fa-users fa-fw"></i> Usuários <span class="fa fa-chevron-down fa-fw"></span></a>
        <ul class="nav child_menu" style="display: none;">
          <li><a href="#">   Usuários e grupos </a></li>
        </ul>
      </li>

      <li class=""><a><i class="fa fa-gears fa-fw"></i> configurações <span class="fa fa-chevron-down fa-fw"></span></a>
        <ul class="nav child_menu" style="display: none;">
          <li><a href="#">   Dados da empresa</a></li>
          <li><a href="#">   Gerenciar Mensalidade</a></li>
        </ul>
      </li>
    </ul>
  </div>

</div>
