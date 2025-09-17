<section class="w-full">
    @include('partials.heading')

    <flux:table>
        <flux:table.columns>
            <flux:table.column>Customer</flux:table.column>
            <flux:table.column sortable sorted direction="desc">Date</flux:table.column>
            <flux:table.column sortable>Amount</flux:table.column>
        </flux:table.columns>
        <!-- ... -->
    </flux:table>

</section>
