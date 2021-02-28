<?php

namespace Infrastructure\Testing;

trait TestRequestTrait
{
    private $rules;

    /** @var Validator */
    private $validator;

    private $showDebugOutput = false;

    /**
     * @test
     * @dataProvider validationProvider
     * @param bool $shouldPass
     * @param array $mockedRequestData
     */
    public function validation_results_as_expected($shouldPass, $mockedRequestData)
    {
        $message = null;
        list($result, $message) = $this->validate($mockedRequestData);
        $this->assertEquals($shouldPass, $result, $message);
    }

    protected function validate($mockedRequestData)
    {
        try {
            $validator = $this->validator->make($mockedRequestData, $this->rules);
            if ($result = $validator->validate()) {
                return [true, ''];
            }
        } catch (\Throwable $th) {
            $errors = $validator->errors();
            $msgs = [];

            $this->writeLn(PHP_EOL . 'All validation errors:' . PHP_EOL);
            foreach ($errors->getMessages() as $key => $messages) {
                $incomingData = \Illuminate\Support\Arr::get($mockedRequestData, $key, '[empty]');
                if (is_array($incomingData) || is_object($incomingData)) {
                    // $incomingData = print_r($incomingData);
                    $incomingData = collect($incomingData)->__toString();
                }
                foreach ($messages as $message) {
                    $line = "\033[0m \033[41m >> \033[1m" . $key . ' => ' . $incomingData . " \033[0m" . ' : ' . "\033[1m" . $message . "\033[0m" . PHP_EOL;
                    $this->writeLn($line);
                    $msgs[] = $line;
                }
            }

            return [false, implode(PHP_EOL, $msgs)];
        }
    }

    private function writeLn($message)
    {
        if ($this->showDebugOutput) {
            fwrite(STDOUT, $message);
        }
    }
}