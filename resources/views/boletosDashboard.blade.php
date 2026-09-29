  @if (($vencidos ?? 0) > 0)
      <div class="col-md-3">
          <div class="card bg-danger text-white">
              <div class="card-body text-center">
                  <h5>Alerta de Boleto</h5>
                  <div class="alert alert-danger mt-3 mb-0 py-2">
                      <i class="fas fa-exclamation-triangle"></i>
                      <strong>{{ $vencidos }} vencido(s)</strong>
                  </div>
              </div>
          </div>
      </div>
  @endif

  @if (($aVencer ?? 0) > 0)
      <div class="col-md-3">
          <div class="card bg-warning text-white">
              <div class="card-body text-center">
                  <h5>Alerta de Boleto</h5>
                  <div class="alert alert-warning mt-3 mb-0 py-2">
                      <i class="fas fa-exclamation-triangle"></i>
                      <strong>{{ $aVencer }} a vencer (7 dias) </strong>
                  </div>
              </div>
          </div>
      </div>
  @endif
