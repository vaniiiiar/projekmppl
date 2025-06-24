<?php

namespace App\Filament\Admin\Resources\OrderResource\RelationManagers;

use App\Models\Payment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class PaymentRelationManager extends RelationManager
{
    protected static string $relationship = 'payment';

    protected static ?string $title = 'Payment Details';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Payment Information')
                    ->schema([
                        Forms\Components\Select::make('method')
                            ->options([
                                'va' => 'Virtual Account',
                                'dana' => 'DANA',
                                'gopay' => 'GoPay',
                                'cash' => 'Cash',
                                'qris' => 'QRIS',
                            ])
                            ->required()
                            ->live()
                            ->columnSpan(1),
                            
                        Forms\Components\TextInput::make('amount')
                            ->numeric()
                            ->required()
                            ->prefix('Rp')
                            ->columnSpan(1),
                            
                        Forms\Components\TextInput::make('transaction_id')
                            ->label('Transaction ID')
                            ->required()
                            ->columnSpan(1),
                            
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'completed' => 'Paid',
                                'failed' => 'Failed',
                                'refunded' => 'Refunded',
                            ])
                            ->required()
                            ->columnSpan(1),
                    ])
                    ->columns(2),
                    
                Forms\Components\Section::make('Payment Proof')
                    ->schema([
                         
                    Forms\Components\FileUpload::make('payment_proof') // Ubah dari bukti_transfer
                    ->label('Payment Proof')
                    ->image()
                    ->directory('payment-proofs/')
                    ->maxSize(2048)
                    ->downloadable()
                    ->openable()
                    ->previewable()
                    ->helperText('Max 2MB. JPG, PNG, or PDF')
                    ->columnSpanFull()
                    ->preserveFilenames() 
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('method')
                    ->formatStateUsing(fn ($state) => match($state) {
                        'va' => 'Virtual Account',
                        'dana' => 'DANA',
                        'gopay' => 'GoPay',
                        'cash' => 'Cash',
                        'qris' => 'QRIS',
                        default => ucfirst($state)
                    })
                    ->sortable()
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('amount')
                    ->money('IDR')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'completed' => 'success',
                        'failed' => 'danger',
                        'refunded' => 'info',
                    })
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('transaction_id')
                    ->label('Transaction ID')
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('method')
                    ->options([
                        'va' => 'Virtual Account',
                        'dana' => 'DANA',
                        'gopay' => 'GoPay',
                        'cash' => 'Cash',
                        'qris' => 'QRIS',
                    ]),
                    
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'failed' => 'Failed',
                        'refunded' => 'Refunded',
                    ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Add Payment')
                    ->modalHeading('Create New Payment'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Edit Payment'),
                    
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
        
            // Di App\Filament\Admin\Resources\OrderResource\RelationManagers\PaymentRelationManager.php


    }
    
    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return $ownerRecord->payment !== null;
    }
}