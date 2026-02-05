<?php

namespace Tests\Feature;

use Tests\TestCase;

class SiteAccessTest extends TestCase
{
    /**
     * Test home page access.
     */
    public function test_home_page_returns_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * Test about page access.
     */
    public function test_about_page_returns_successful_response(): void
    {
        $response = $this->get('/nosotros');
        $response->assertStatus(200);
    }

    /**
     * Test rentals page access.
     */
    public function test_rentals_page_returns_successful_response(): void
    {
        $response = $this->get('/renta-de-maquinaria');
        $response->assertStatus(200);
    }

    /**
     * Test sales page access.
     */
    public function test_sales_page_returns_successful_response(): void
    {
        $response = $this->get('/venta-de-maquinaria');
        $response->assertStatus(200);
    }

    /**
     * Test invoicing page access.
     */
    public function test_invoicing_page_returns_successful_response(): void
    {
        $response = $this->get('/facturacion');
        $response->assertStatus(200);
    }

    /**
     * Test quote page access.
     */
    public function test_quote_page_returns_successful_response(): void
    {
        $response = $this->get('/cotizacion');
        $response->assertStatus(200);
    }

    /**
     * Test contact page access.
     */
    public function test_contact_page_returns_successful_response(): void
    {
        $response = $this->get('/contacto');
        $response->assertStatus(200);
    }
}
