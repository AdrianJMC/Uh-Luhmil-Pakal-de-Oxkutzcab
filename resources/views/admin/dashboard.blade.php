            {{-- resources/views/admin/dashboard.blade.php --}}

            @extends('layouts.admin')

            @section('title', 'Dashboard Uh Luhmil Pakal')

            @section('content')
                <!-- Content Header (Page header) -->
                <div class="content-header">
                    <div class="container-fluid">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1 class="m-0">Dashboard</h1>
                            </div><!-- /.col -->
                            <div class="col-sm-6">
                                <ol class="breadcrumb float-sm-right">
                                    <li class="breadcrumb-item"><a href="{{ route('inicio') }}">Home</a></li>
                                    <li class="breadcrumb-item active">Dashboard</li>
                                </ol>
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div><!-- /.container-fluid -->
                </div>
                <!-- /.content-header -->

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        <!-- Small boxes (Stat box) -->
                        <div class="row">
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>{{ $totalPedidos }}</h3>

                                        <strong><p>Pedidos Recibidos</p></strong>   
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-bag text-white"></i>
                                    </div>
                                    <a href="{{ route('admin.pedidos.index') }}" class="small-box-footer">
                                        Más información <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3>{{ $totalProductosAprobados }}</h3>

                                        <strong><p class="text-white">Productos Aprobados</p></strong>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-checkmark text-white"></i>
                                    </div>
                                    <a href="{{ route('admin.productos.index') }}" class="small-box-footer">
                                        Más información <i class="fas fa-arrow-circle-right"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-warning">
                                    <div class="inner text-white">
                                        <h3 class="text-white">{{ $totalUsuarios }}</h3>
                                        <strong><p class="text-white">Usuarios Registrados</p></strong>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add text-white"></i>
                                    </div>
                                    <a href="{{ route('admin.users.index') }}" class="small-box-footer text-white"
                                        style="color: white !important;">
                                        Más información <i class="fas fa-arrow-circle-right text-white"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- ./col -->
                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h3>{{ $agrupacionesAprobadas }}</h3>

                                        <strong><p class="text-white">Agrupaciones Aprobadas</p></strong>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-pie-graph text-white"></i>
                                    </div>
                                    <a href="{{ route('admin.agrupaciones.index') }}" class="small-box-footer">
                                        Más información <i class="fas fa-arrow-circle-right "></i>
                                    </a>
                                </div>
                            </div>
                            <!-- ./col -->
                        </div>
                        <!-- /.row -->
                        <!-- Main row -->
                        <div class="row">
                            <!-- Left col -->
                            <section class="col-lg-7 connectedSortable">
                                <!-- Custom tabs (Charts with tabs)-->
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            <i class="fas fa-chart-pie mr-1"></i>
                                            Sales
                                        </h3>
                                        <div class="card-tools">
                                            <ul class="nav nav-pills ml-auto">
                                                <li class="nav-item">
                                                    <a class="nav-link active" href="{{ url('#revenue-chart') }}"
                                                        data-toggle="tab">Area</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" href="{{ url('#sales-chart') }}"
                                                        data-toggle="tab">Donut</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div><!-- /.card-header -->
                                    <div class="card-body">
                                        <div class="tab-content p-0">
                                            <!-- Morris chart - Sales -->
                                            <div class="chart tab-pane active" id="revenue-chart"
                                                style="position: relative; height: 300px;">
                                                <canvas id="revenue-chart-canvas" height="300"
                                                    style="height: 300px;"></canvas>
                                            </div>
                                            <div class="chart tab-pane" id="sales-chart"
                                                style="position: relative; height: 300px;">
                                                <canvas id="sales-chart-canvas" height="300"
                                                    style="height: 300px;"></canvas>
                                            </div>
                                        </div>
                                    </div><!-- /.card-body -->
                                </div>
                                <!-- /.card -->


                                <!-- /.card -->
                            </section>
                            <!-- /.Left col -->
                            <!-- right col (We are only adding the ID to make the widgets sortable)-->
                            <section class="col-lg-5 connectedSortable">


                                <!-- solid sales graph -->
                                <div class="card bg-gradient-info">
                                    <div class="card-header border-0">
                                        <div class="d-flex justify-content-between align-items-start w-100">
                                            <!-- Título -->
                                            <div>
                                                <h3 class="card-title m-0">
                                                    <i class="fas fa-th mr-1"></i>
                                                    Sales Graph
                                                </h3>
                                                <!-- Selector debajo del título -->
                                                <select id="tipoGrafica"
                                                    class="form-control form-control-sm align-items-center w-60 mt-5">
                                                    <option value="productos" selected>Productos más vendidos</option>
                                                    <option value="agrupaciones">Ventas por agrupación</option>
                                                    <option value="dias">Ventas últimos 7 días</option>
                                                </select>
                                            </div>

                                            <!-- Botones -->
                                            <div class="card-tools ml-0 mt-0">
                                                <button type="button" class="btn bg-info btn-sm"
                                                    data-card-widget="collapse">
                                                    <i class="fas fa-minus"></i>
                                                </button>
                                                <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <canvas class="chart" id="line-chart"
                                            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                    </div>

                                    <!-- Footer -->
                                    <div class="card-footer bg-transparent">
                                        <div class="row">
                                            <div class="col-4 text-center">
                                                <h4 class="text-white mb-0">{{ $ventasPorAgrupacion->count() }}</h4>
                                                <div class="text-white">Agrupaciones con Ventas</div>
                                            </div>
                                            <div class="col-4 text-center">
                                                <h4 class="text-white mb-0">
                                                    {{ number_format($ventasPorDia->sum('total')) }}</h4>
                                                <div class="text-white">Ventas últimos 7 días</div>
                                            </div>
                                            <div class="col-4 text-center">
                                                <h4 class="text-white mb-0">{{ $topProductos->sum('total_vendidos') }}
                                                </h4>
                                                <div class="text-white">Productos más vendidos</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </section>
                            <!-- right col -->
                        </div>
                        <!-- /.row (main row) -->
                    </div><!-- /.container-fluid -->
                </section>
            @endsection

            @push('scripts')
                <script>
                    window.datosVentas = {
                        ventasPorMes: {
                            meses: @json($ventasPorMes->pluck('mes')),
                            totales: @json($ventasPorMes->pluck('total_ventas')),
                        },
                        ventasPorCategoria: {
                            categorias: @json($ventasPorCategoria->pluck('categoria')),
                            cantidades: @json($ventasPorCategoria->pluck('total')),
                        },
                        graficaDinamica: {
                            productos: {
                                labels: @json($topProductos->pluck('nombre')),
                                data: @json($topProductos->pluck('total_vendidos')),
                                label: 'Productos más vendidos',
                                bg: 'rgba(255, 99, 132, 0.7)',
                                border: 'rgba(255, 99, 132, 1)',
                            },
                            agrupaciones: {
                                labels: @json($ventasPorAgrupacion->pluck('nombre')),
                                data: @json($ventasPorAgrupacion->pluck('total')),
                                label: 'Ventas por agrupación',
                                bg: 'rgba(0, 255, 204, 0.7)',
                                border: 'rgba(0, 255, 204, 1)',
                            },
                            dias: {
                                labels: @json($ventasPorDia->pluck('fecha')->map(fn($f) => \Carbon\Carbon::parse($f)->format('d M'))),
                                data: @json($ventasPorDia->pluck('total')),
                                label: 'Ventas por día (últimos 7)',
                                bg: 'rgba(255, 206, 86, 0.9)',
                                border: 'rgba(255, 206, 86, 1)',
                            }
                        }
                    };
                </script>
                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script src="{{ asset('js/dashboard.js') }}"></script>
            @endpush
