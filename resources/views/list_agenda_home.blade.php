@foreach ($agendas as $agenda)
    <div class="timeline-item timeline-day">
        <div class="timeline-time">{{ date('d/m', strtotime($agenda['agendata'])) }}</div>
        <div class="timeline-body">
            <p class="timeline-date">{{ $agenda['titulo'] }}</p>
            @if ($agenda['created_at'] != $agenda['updated_at'])
                <span class="badge bg-warning">Editado: {{ date('d/m/Y', strtotime($agenda['updated_at'])) }}</span>
            @endif
        </div><!-- timeline-body -->
    </div><!-- timeline-item -->
    <div class="timeline-item">
        <div class="timeline-time">{{ date('H:i', strtotime($agenda['agenhora'])) }}</div>
        <div class="timeline-body">
            <p class="timeline-title"><a href=""
                    class="logged-user text-decoration-none">{{ $agenda['observacao'] }}</a>
            </p>

            <p class="timeline-text">
                {{ $agenda['mensagem'] }}
            </p>
            <a href="{{ route('editAgenda', ['id' => Crypt::encrypt($agenda['id'])]) }}"
                class="btn btn-outline-secondary btn-sm mx-1  rounded-pill"><i
                    class="fa-regular fa-pen-to-square"></i></a>
            <a href="{{ route('deleteAgenda', ['id' => Crypt::encrypt($agenda['id'])]) }}"
                class="btn btn-outline-danger btn-sm mx-1  rounded-pill"> <i class="fa-regular fa-trash-can"></i></a>
        </div><!-- timeline-body -->
    </div><!-- timeline-item -->
@endforeach
