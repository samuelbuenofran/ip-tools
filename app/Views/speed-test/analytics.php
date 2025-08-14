<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4><i class="fa-solid fa-chart-bar"></i> Speed Test Analytics</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-success">
                        <i class="fa-solid fa-check-circle"></i>
                        <strong>Analytics are Live!</strong> View detailed speed test analytics and performance metrics.
                    </div>
                    
                    <div class="row">
                        <div class="col-md-8">
                            <h5>Available Analytics:</h5>
                            <ul class="list-unstyled">
                                <li><i class="fa-solid fa-chart-line text-success me-2"></i> Performance trends over time</li>
                                <li><i class="fa-solid fa-table text-primary me-2"></i> Detailed test history</li>
                                <li><i class="fa-solid fa-calculator text-warning me-2"></i> Average speeds and statistics</li>
                                <li><i class="fa-solid fa-map-marker-alt text-info me-2"></i> Location-based performance data</li>
                                <li><i class="fa-solid fa-download text-secondary me-2"></i> Download/Upload speed comparisons</li>
                            </ul>
                        </div>
                        <div class="col-md-4 text-center">
                            <a href="<?= $view->url('utils/speed_analytics') ?>" class="btn btn-primary btn-lg">
                                <i class="fa-solid fa-chart-bar"></i> View Full Analytics
                            </a>
                            <br><br>
                            <a href="<?= $view->url('utils/speedtest') ?>" class="btn btn-outline-success">
                                <i class="fa-solid fa-play"></i> Run Speed Test
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 