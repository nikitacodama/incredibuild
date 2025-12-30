<?php
    $title = get_sub_field('title');
    $text = get_sub_field('text');
    $fetch_data_url = get_sub_field('fetch_data_url');
?>

<section class="open_positions" id="open_positions">
    <div class="open_positions-top container container_sm text_c">
    <div class="point_list-before"></div>
        <?php if($title): ?>
            <h2 class="open_positions-title white medium text_c"><?php echo $title; ?></h2>
        <?php endif; ?>
        <?php if($text): ?>
            <div class="open_positions-text fz_18 medium white-70"><?php echo $text; ?></div>
        <?php endif; ?>
        </div>
        <div class="open_positions-content container container_sm">

        <?php if($fetch_data_url): ?>
            <div class="jobs_c">
<?php

$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => $fetch_data_url ,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
));

$jobs = json_decode(curl_exec($curl));
curl_close($curl);

$jobs_params = array('locations' => array(), 'departments' => array());
?>

<div class="open_positions-search">
    
    <div class="open_positions-filter flex align_c justify_fs">
        <span class="open_positions-search-title fz_18 white-70">Filter by</span>

        <div class="open_positions-selects flex align_c justify_fs gap_12">
        <!-- Locations Filter -->
        <?php
        if (is_array($jobs)) {
            foreach ($jobs as $job) {
                $loc = $job->location->name;
                $dep = $job->department;

                if (!in_array($loc, $jobs_params['locations'])) {
                    $jobs_params['locations'][] = $loc;
                }
                if (!in_array($dep, $jobs_params['departments'])) {
                    $jobs_params['departments'][] = $dep;
                }
            }
        }

        $locations = $jobs_params['locations'];
        if (!empty($locations)) : ?>
            <select class="open_positions-search-select" id="jobs_locations" name="jobs_locations">
                <?php if (count($locations) > 1) : ?>
                    <option value="all">All Locations</option>
                <?php endif; ?>

                <?php foreach ($locations as $location) :
                    $selected = (isset($_REQUEST['loc']) && strcasecmp($_REQUEST['loc'], $location) == 0) ? 'selected' : ''; ?>
                    <option value="<?= $location ?>" <?= $selected ?>><?= $location ?></option>
                <?php endforeach; ?>
            </select>
        <?php endif; ?>

        <!-- Departments Filter -->
        <?php
        $departments = $jobs_params['departments'];
        if (!empty($departments)) : ?>
            <select class="open_positions-search-select" id="jobs_departments" name="jobs_departments">
                <?php if (count($departments) > 1) : ?>
                    <option value="all">All Departments</option>
                <?php endif; ?>

                <?php foreach ($departments as $department) :
                    $selected = (isset($_REQUEST['dep']) && strcasecmp($_REQUEST['dep'], $department) == 0) ? 'selected' : ''; ?>
                    <option value="<?= $department ?>" <?= $selected ?>><?= $department ?></option>
                <?php endforeach; ?>
            </select>
        <?php endif; ?>
</div>
        <!-- Count (HTML only, PHP inside) -->
        <span class="open_positions-search-count white tt_u ff_mono">
            <?php echo is_array($jobs) ? count($jobs) : 0; ?> Open positions
        </span>
    </div>
</div>

<!-- Jobs List -->
<?php if (is_array($jobs)) : ?>
    <div class="open_positions-list flex dir_col gap_16">
        <?php foreach ($jobs as $job) :
            $job_location = $job->location->name;
            $job_department = $job->department;
        ?>
            <div class="open_positions-list-item" data-location="<?php echo $job_location ?>" data-department="<?php echo $job_department ?>">
                <a class="open_positions-list-item-link flex align_c justify_sb" href="<?php echo $job->url_active_page ?>" aria-label="More info about <?php echo $job->name ?> position on Comeet" target="_blank">
                    <span class="open_positions-list-item-link-title white medium" aria-label="Position Name"><?php echo $job->name ?></span>
                    <span class="open_positions-list-item-link-location" aria-label="Job Location"><?php echo $job_location ?></span>
                    <span class="open_positions-list-item-link-apply green tt_u ff_mono arrow_r">Apply</span>
                </a>
            </div>
        <?php endforeach; ?>
        </div>
<?php endif; ?>
    </div>
        <?php endif; ?>
        </div>
</section>