<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class OrdersExport implements FromCollection, WithHeadings, WithMapping
{
    private string $q;
    private string $dateFrom;
    private string $dateTo;

    public function __construct(string $q = '', string $dateFrom = '', string $dateTo = '')
    {
        $this->q = $q;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    public function collection()
    {
        $query = Order::orderBy('id', 'desc');

        if ($this->q !== '') {
            $q = $this->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('code_bill', 'like', "%{$q}%")
                    ->orWhere('fullname', 'like', "%{$q}%")
                    ->orWhere('phone', 'like', "%{$q}%");
            });
        }

        if ($this->dateFrom !== '') {
            $dateFrom = \Carbon\Carbon::parse($this->dateFrom)->startOfDay();
            $query->where('created_at', '>=', $dateFrom);
        }

        if ($this->dateTo !== '') {
            $dateTo = \Carbon\Carbon::parse($this->dateTo)->endOfDay();
            $query->where('created_at', '<=', $dateTo);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Mã đơn',
            'Khách hàng',
            'SĐT',
            'Email',
            'Địa chỉ',
            'Ghi chú',
            'Số lượng sản phẩm',
            'Tổng tiền (VNĐ)',
            'Chi tiết sản phẩm',
            'Phương thức TT',
            'Trạng thái',
            'Thời gian tạo',
        ];
    }

    public function map($order): array
    {
        $status = match ((int)$order->progress) {
            0 => 'Chờ xác nhận',
            4 => 'Đã xác nhận',
            1 => 'Đang giao',
            2 => 'Thành công',
            3 => 'Đã hủy',
            default => 'Không rõ',
        };

        $methodPay = match ((int)$order->method_pay) {
            0 => 'Thanh toán tại nhà',
            1 => 'Thanh toán tại cửa hàng',
            default => 'Chưa xác định',
        };

        // Parse product details from JSON
        $productsJson = json_decode($order->product, true) ?? [];
        $productDetails = [];
        foreach ($productsJson as $item) {
            $name = $item['name'] ?? '';
            $qty = $item['qty'] ?? 1;
            $price = number_format($item['price'] ?? 0, 0, '', '.') . 'đ';
            $opt = '';
            if (isset($item['options']['option'])) {
                $opt = " ({$item['options']['option']})";
            } elseif (isset($item['options']['size'])) {
                $opt = " (Size {$item['options']['size']})";
            }
            $productDetails[] = "- {$name}{$opt} x{$qty} (Đơn giá: {$price})";
        }
        $productDetailsStr = implode("\n", $productDetails);

        return [
            $order->id,
            $order->code_bill,
            $order->fullname,
            $order->phone,
            $order->email,
            $order->address,
            $order->note ?? '',
            $order->amount,
            (int) $order->total,
            $productDetailsStr,
            $methodPay,
            $status,
            optional($order->created_at)->format('d/m/Y H:i:s'),
        ];
    }
}
