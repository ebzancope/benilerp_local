
      <div class="col-md-3">
          <div class="card bg-success text-white">
              <div class="card-body text-center">
                  <h5>Faturamento de caminhões</h5>
                  <div class="alert alert-danger mt-3 mb-0 py-2">
                      <i class="fas fa-exclamation-triangle"></i>
                      <strong>R$ {{ number_format($totais['caminhoes']['valor'], 2, ',', '.') }}</strong>
                  </div>
              </div>
          </div>
      </div>


            <div class="col-md-3">
          <div class="card bg-success text-white">
              <div class="card-body text-center">
                  <h5>Faturamento de máquinas</h5>
                  <div class="alert alert-danger mt-3 mb-0 py-2">
                      <i class="fas fa-exclamation-triangle"></i>
                      <strong>R$ {{ number_format($totais['maquinas']['valor'], 2, ',', '.') }}</strong>
                  </div>
              </div>
          </div>
      </div>



      <div class="col-md-3">
          <div class="card bg-success text-white">
              <div class="card-body text-center">
                  <h5>Faturamento Geral</h5>
                  <div class="alert alert-warning mt-3 mb-0 py-2">
                      <i class="fas fa-exclamation-triangle"></i>
                      <strong>Total: R$ {{ number_format($totais['geral'], 2, ',', '.') }}</strong>
                  </div>
              </div>
          </div>
      </div>


