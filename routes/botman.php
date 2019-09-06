<?php
use App\Http\Controllers\BotManController;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\Drivers\Facebook\Extensions\ButtonTemplate;
use BotMan\Drivers\Facebook\Extensions\Element;
use BotMan\Drivers\Facebook\Extensions\ElementButton;
use BotMan\Drivers\Facebook\Extensions\GenericTemplate;
use BotMan\Drivers\Facebook\Extensions\ListTemplate;
use BotMan\BotMan\Messages\Incoming\Answer;

$botman = resolve('botman');

$botman->hears('Hi', function ($bot) {
    $bot->typesAndWaits(2);
    $bot->reply('Hello!');
});

$botman->hears('Start conversation', BotManController::class.'@startConversation');
$botman->hears('shafqat', function ($bot) {
    $bot->reply('Hello! shafqat');
});
$botman->hears('bye', function ($bot) {
    $bot->reply('good bye!');
});
$botman->hears('image', function ($bot) {
    // Create attachment
    $attachment = new Image('http://175.107.206.46/wp-content/uploads/2018/02/Cloud-campaign-portal.jpg');

    // Build message object
    $message = OutgoingMessage::create('this is new image')
                ->withAttachment($attachment);

    // Reply message object
    $bot->reply($message);
});
$botman->hears('question', function ($bot) {
$bot->reply(ButtonTemplate::create('Do you want to know more about BotMan?')
	->addButton(ElementButton::create('Tell me more')->type('postback')->payload('tellmemore'))
	->addButton(ElementButton::create('Show me the docs')->url('http://botman.io/'))
);
});
$botman->hears('HospitALL IVF Get Started En', function ($bot) {
$bot->reply(ButtonTemplate::create('We would love to ask a couple of questions in order to understand your needs! Would you like to proceed or should we give you a call instead?')
	->addButton(ElementButton::create('Yes, Proceed!')->type('postback')->payload('yes_proceed'))
	->addButton(ElementButton::create('Call me instead!')->url('http://botman.io/'))
);
});
$botman->hears('tellmemore', function ($bot) {
    $bot->ask('Kindly mention your age and your spouse age?',function(Answer $answer){
        $answer->say('For how long have you been married?');
    });
});
// $botman->hears('tellmemore', function ($bot) {
//     $bot->reply('okay i will tell you more');
// });

$botman->hears('template', function ($bot) {
$bot->reply(GenericTemplate::create()
	->addImageAspectRatio(GenericTemplate::RATIO_SQUARE)
	->addElements([
		Element::create('BotMan Documentation')
			->subtitle('All about BotMan')
			->image('http://botman.io/img/botman-body.png')
			->addButton(ElementButton::create('visit')->url('http://botman.io'))
			->addButton(ElementButton::create('tell me more')
				->payload('tellmemore')->type('postback')),
		Element::create('BotMan Laravel Starter')
			->subtitle('This is the best way to start with Laravel and BotMan')
			->image('http://botman.io/img/botman-body.png')
			->addButton(ElementButton::create('visit')
				->url('https://github.com/mpociot/botman-laravel-starter')
			)
	])
);
});
$botman->hears('list-template', function($bot) {
	$bot->reply(ListTemplate::create()
	->useCompactView()
	->addGlobalButton(ElementButton::create('view more')->url('http://test.at'))
	->addElement(
		Element::create('BotMan Documentation')
			->subtitle('All about BotMan')
			->image('http://botman.io/img/botman-body.png')
			->addButton(ElementButton::create('tell me more')
				->payload('tellmemore')->type('postback'))
	)
	->addElement(
		Element::create('BotMan Laravel Starter')
			->subtitle('This is the best way to start with Laravel and BotMan')
			->image('http://botman.io/img/botman-body.png')
			->addButton(ElementButton::create('visit')
				->url('https://github.com/mpociot/botman-laravel-starter')
			)
	)
);
});
$botman->hears('call me {name}', function ($bot, $name) {
    $bot->reply('Your name is: '.$name);
});

$botman->hears('.*nice.*', function ($bot) {
    $bot->reply('Nice to meet you!');
});
$botman->fallback(function($bot) {
    $bot->reply('Sorry, I did not understand these commands. Here is a list of commands I understand: ...');
});
$botman->hears('Hello', function($bot) {
	$user = $bot->getUser();
	$bot->reply('Hello '.$user->getFirstName().' '.$user->getLastName());
	$bot->reply('Your username is: '.$user->getProfilePic ());
	$bot->reply('Your gender is: '.$user->getGender ());
	$bot->reply('Your ID is: '.$user->getId());
});
