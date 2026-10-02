<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('passes:prune')->dailyAt('03:00')->onOneServer();
