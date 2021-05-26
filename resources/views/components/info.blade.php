
<div class="dropdown is-hoverable {{!$attributes["isBottom"] ? 'is-up' : ''}} {{$attributes["position"]}}">
    <div class="dropdown-trigger">
        <i class="fa fa-question-circle has-text-success is-clickable" aria-hidden="true"></i>
    </div>
    <div class="dropdown-menu" id="dropdown-menu4" role="menu">
      <div class="dropdown-content">
        <div class="dropdown-item">
            {{ $slot }}
        </div>
      </div>
    </div>
</div>
