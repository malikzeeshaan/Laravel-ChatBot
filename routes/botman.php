<?php
use App\Http\Controllers\BotManController;

$botman = resolve('botman');

$botman->hears('Hi', function ($bot) {
    $bot->reply('Hello!');
});
$botman->hears('Start conversation', BotManController::class.'@startConversation');
$botman->hears('shafqat', function ($bot) {
    $bot->reply('Hello! shafqat');
});
$botman->hears('bye', function ($bot) {
    $bot->reply('good bye!');
});