<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fa-solid fa-gauge-high"></i> Speed Test</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-success">
                        <i class="fa-solid fa-check-circle"></i>
                        <strong>Speed Test is Live!</strong> Test your internet connection speed with our advanced speed testing tool.
                    </div>
                    
                    <div class="row">
                        <div class="col-md-8">
                            <h5>Features:</h5>
                            <ul class="list-unstyled">
                                <li><i class="fa-solid fa-download text-success me-2"></i> Download speed testing</li>
                                <li><i class="fa-solid fa-upload text-primary me-2"></i> Upload speed testing</li>
                                <li><i class="fa-solid fa-clock text-warning me-2"></i> Ping and latency measurement</li>
                                <li><i class="fa-solid fa-chart-line text-info me-2"></i> Detailed analytics and history</li>
                                <li><i class="fa-solid fa-globe text-secondary me-2"></i> Location-based results</li>
                            </ul>
                        </div>
                        <div class="col-md-4 text-center">
                            <a href="<?= $view->url('utils/speedtest') ?>" class="btn btn-primary btn-lg">
                                <i class="fa-solid fa-play"></i> Start Speed Test
                            </a>
                            <br><br>
                            <a href="<?= $view->url('utils/speed_analytics') ?>" class="btn btn-outline-info">
                                <i class="fa-solid fa-chart-bar"></i> View Analytics
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 