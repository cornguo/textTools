<?php namespace CornGuo;

class Text {

    private $_text = NULL;

    public function __construct($text) {
        $this->setText($text);
    }

    public function setText($text) {
        $this->_text = $text;
    }

    public function normalize() {
        // TODO: CornGuo\Text\...
        return $this;
    }

    public function getChunk($method = 'bigram') {
        // TODO: CornGuo\Text\...
    }

    public function getPOS($tagger = 'NTOU') {
        // TODO: CornGuo\Text\...
    }

    public function getPhonic($system = 'bopomofo') {
        // TODO: CornGuo\Text\...
    }

}
