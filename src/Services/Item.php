<?php namespace Innovativesprouts\MayaPayment\Services;

class Item{
    protected array $items = [];
    protected string $currency_code = "PHP";
    protected array $totalAmount = [];
    protected array $required_item_fields = [
        "amount", "totalAmount", "name", "code", "description", "quantity"
    ];

    /**
     * @param array $item
     * @return $this
     * @throws \Exception
     */
    public function addItem($item = []): Item
    {
        if (empty($item)){
            return $this;
        }

        foreach ($this->required_item_fields as $required_item_field) {
            if (!array_key_exists($required_item_field, $item)){
                throw new \Exception("This {$required_item_field} field is not found in your new item.");
            }
        }

        if ($searched_index = array_search($item['code'], $this->getItems(), true) !== false){
            $inline_item = $this->getItems()[$searched_index];
            $inline_item['quantity'] += (float) $item['quantity'];
            $inline_item['totalAmount']['value'] += (float) ($inline_item['amount']['value'] * $inline_item['quantity']);
            $inline_item['quantity'] = (string) $inline_item['quantity'];
        }else{
            $this->items[] = $item;
        }

        return $this;
    }

    public function getItems(): array
    {
        return $this->items;
    }

}
