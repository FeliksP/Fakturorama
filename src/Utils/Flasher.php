<?php


namespace App\Utils;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Flasher {
    private $translator;
    private $session;
    
    public function __construct(TranslatorInterface $translator, SessionInterface $session) {
        $this->translator = $translator;
        $this->session = $session;
    }
    
    public function flashSuccess ($message ) {
          
        $this->session->getFlashBag()->add('success', $this->translateMsg($message));
    }
    
    public function flashError ($message ) {
          
        $this->session-> getFlashBag()->add('danger', $this->translateMsg($message));
    }
    
    
    private function translateMsg ($message) : string {
        $translated = $this->translator->trans($message)   ;
        return $translated ;
    }
}
