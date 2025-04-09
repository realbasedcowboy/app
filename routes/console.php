<?php

Schedule::command(\App\Console\Commands\FetchCryptoPrices::class)->everyFiveMinutes();
