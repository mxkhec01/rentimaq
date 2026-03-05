<?php

namespace Tests\Feature;

use App\Mail\QuoteRequested;
use App\Models\Contact;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class QuoteEmailTest extends TestCase
{
    use RefreshDatabase;

    private function createRentalProduct(string $name = 'Revolvedora de un saco'): Product
    {
        return Product::create([
            'name' => $name,
            'slug' => \Illuminate\Support\Str::slug($name),
            'category' => 'Concreto',
            'is_rental' => true,
            'is_for_sale' => false,
            'is_active' => true,
        ]);
    }

    public function test_submitting_quote_saves_contact_to_database(): void
    {
        $product = $this->createRentalProduct();
        Mail::fake();

        Livewire::test(\App\Livewire\QuoteBuilder::class)
            ->call('addToQuote', $product->id)
            ->set('contact.name', 'Juan Pérez')
            ->set('contact.email', 'juan@test.com')
            ->set('contact.phone', '4421234567')
            ->set('contact.company', 'Constructora XYZ')
            ->set('contact.city', 'Querétaro')
            ->set('contact.address', 'Av. Universidad 100')
            ->call('submitQuote');

        $this->assertDatabaseCount('contacts', 1);
        $this->assertDatabaseHas('contacts', [
            'name' => 'Juan Pérez',
            'email' => 'juan@test.com',
            'company' => 'Constructora XYZ',
        ]);
    }

    public function test_submitting_quote_sends_email(): void
    {
        $product = $this->createRentalProduct();
        Mail::fake();

        Livewire::test(\App\Livewire\QuoteBuilder::class)
            ->call('addToQuote', $product->id)
            ->set('contact.name', 'María García')
            ->set('contact.email', 'maria@test.com')
            ->set('contact.phone', '4429876543')
            ->set('contact.company', 'Obras MG')
            ->set('contact.city', 'León')
            ->call('submitQuote');

        Mail::assertSent(QuoteRequested::class, function (QuoteRequested $mail): bool {
            return $mail->contact->name === 'María García'
                && $mail->contact->company === 'Obras MG';
        });
    }

    public function test_quote_email_contains_correct_item_data(): void
    {
        $product = $this->createRentalProduct('Compactadora Bailarina');
        Mail::fake();

        Livewire::test(\App\Livewire\QuoteBuilder::class)
            ->call('addToQuote', $product->id)
            ->set('quoteItems.0.qty', 3)
            ->set('quoteItems.0.duration', 2)
            ->set('quoteItems.0.period', 'week')
            ->set('contact.name', 'Carlos López')
            ->set('contact.email', 'carlos@test.com')
            ->set('contact.phone', '4425551234')
            ->set('contact.company', 'Build Co')
            ->set('contact.city', 'Querétaro')
            ->call('submitQuote');

        Mail::assertSent(QuoteRequested::class, function (QuoteRequested $mail): bool {
            $items = $mail->contact->metadata['items'] ?? [];

            return count($items) === 1
                && $items[0]['product'] === 'Compactadora Bailarina'
                && $items[0]['quantity'] === 3;
        });
    }

    public function test_quote_without_items_fails_validation(): void
    {
        Mail::fake();

        Livewire::test(\App\Livewire\QuoteBuilder::class)
            ->set('contact.name', 'Test User')
            ->set('contact.email', 'test@test.com')
            ->set('contact.phone', '1234567890')
            ->set('contact.company', 'Test Co')
            ->set('contact.city', 'Test City')
            ->call('submitQuote')
            ->assertHasErrors(['quoteItems']);

        Mail::assertNothingSent();
        $this->assertDatabaseCount('contacts', 0);
    }
}
