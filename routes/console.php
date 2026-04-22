<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('passes:prune')->hourly()->onOneServer();
