<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('id')->disabled(),
            Forms\Components\Select::make('user_id')
                ->relationship('user', 'name')
                ->disabled(),
            Forms\Components\Select::make('status')
                ->options([
                    'pending' => 'Pending',
                    'paid' => 'Paid',
                    'failed' => 'Failed',
                ])
                ->required(),
            Forms\Components\TextInput::make('total_usd')->numeric()->disabled(),
            Forms\Components\Toggle::make('downloads_disabled'),
            Forms\Components\DateTimePicker::make('paid_at'),
            Forms\Components\Repeater::make('items')
                ->relationship()
                ->schema([
                    Forms\Components\TextInput::make('product_id')->label('Product ID')->disabled(),
                    Forms\Components\TextInput::make('price_usd')->label('Price (USD)')->disabled(),
                ])
                ->disabled()
                ->dehydrated(false)
                ->columnSpanFull(),
            Forms\Components\Repeater::make('payments')
                ->relationship()
                ->schema([
                    Forms\Components\TextInput::make('status')->disabled(),
                    Forms\Components\TextInput::make('stripe_checkout_session_id')->disabled(),
                    Forms\Components\TextInput::make('stripe_payment_intent_id')->disabled(),
                    Forms\Components\TextInput::make('amount_usd')->disabled(),
                ])
                ->disabled()
                ->dehydrated(false)
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('user.name')->label('Customer')->searchable(),
                Tables\Columns\TextColumn::make('status')->badge(),
                Tables\Columns\IconColumn::make('downloads_disabled')->boolean(),
                Tables\Columns\TextColumn::make('total_usd')->money('USD'),
                Tables\Columns\TextColumn::make('latestPayment.status')->badge()->label('Payment'),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('toggle_downloads')
                    ->label(fn (Order $record) => $record->downloads_disabled ? 'Enable Downloads' : 'Disable Downloads')
                    ->action(function (Order $record): void {
                        $record->update(['downloads_disabled' => ! $record->downloads_disabled]);

                        Notification::make()
                            ->title('Order download state updated.')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with(['user', 'latestPayment']);
    }
}
