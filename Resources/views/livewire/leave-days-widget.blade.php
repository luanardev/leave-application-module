@push('css')
    <style>
        .leave-days-widget .donut-chart {
            min-height: 250px;
            height: 250px;
            max-height: 250px;
            max-width: 100%;
            display: block;
            width: 444px;
        }
    </style>

@endpush

<div class="leave-days-widget">
    <div class="card card-outline card-info">
        <div class="card-header">
            <div class="card-title ">
                {{$leaveType->getName()}}
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-12">
                    <canvas class="donut-chart chartjs-render-monitor" width="666" height="375"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

@push('js')

    <script>
        $(function () {

            const donutChartCanvas = $('.donut-chart').get(0).getContext('2d');
            const donutData = {
                labels: [
                    "{{$this->leaveType->getUnit()}} Taken : {{$this->daysTaken()}}",
                    "{{$this->leaveType->getUnit()}} Balance : {{$this->daysRemaining()}}",
                    "{{$this->leaveType->getUnit()}} Accrued : {{$this->daysAllowed()}} ",
                ],
                datasets: [
                    {
                        data: [
                            {{ $this->daysTaken() }},
                            {{ $this->daysRemaining() }},
                            {{ $this->daysAllowed() }}
                        ],
                        backgroundColor: ['#08b3fc','#f56954', '#00a65a' ],
                    }
                ]
            };
            const donutOptions = {
                maintainAspectRatio: false,
                responsive: true,
            };

            new Chart(donutChartCanvas, {
                type: 'doughnut',
                data: donutData,
                options: donutOptions
            })

        });
    </script>

@endpush


