<?php

namespace App\Services;

use Google\Client;
use Google\Service\Sheets;

class GoogleSheetsService
{
    protected $client;
    protected $service;
    protected $spreadsheetId;
    protected $sheetName;

    public function __construct()
    {
        $this->spreadsheetId = env('GOOGLE_SHEETS_SPREADSHEET_ID');
        $this->sheetName = env('GOOGLE_SHEETS_SHEET_NAME');

        $this->client = new Client();
        $this->client->setAuthConfig(storage_path('app/google-sheets.json'));
        $this->client->addScope(Sheets::SPREADSHEETS);

        $this->service = new Sheets($this->client);
    }

    public function appendRow(array $values)
    {
        $range = "{$this->sheetName}!A:Z"; // Ghi vào cột A đến Z
        $body = new Sheets\ValueRange(['values' => [$values]]);
        $params = ['valueInputOption' => 'RAW'];

        return $this->service->spreadsheets_values->append($this->spreadsheetId, $range, $body, $params);
    }
}
