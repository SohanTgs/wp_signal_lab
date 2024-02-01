<?php

namespace Viserlab\Notify;

interface Notifiable
{
	public function send();

	public function prevConfiguration();
}