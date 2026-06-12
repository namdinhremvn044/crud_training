<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // ISBN bắt buộc và không được trùng
            'isbn' => ['bail', 'required', 'string', 'max:255', Rule::unique('books', 'isbn')],

            // Tên sách bắt buộc
            'title' => ['bail', 'required', 'string', 'max:255'],

            // Tác giả bắt buộc
            'author_id' => ['bail', 'required', 'integer', 'exists:authors,id'],

            // Giá sách phải lớn hơn 0
            'price' => ['bail', 'required', 'numeric', 'gt:0', 'decimal:0,2'],

            // Số lượng phải >= 0
            'quantity' => ['bail', 'required', 'integer', 'min:0'],

            // Ngày xuất bản không được lớn hơn ngày hiện tại
            'publish_date' => ['bail', 'required', 'date', 'before_or_equal:today'],

            // Ảnh bìa không bắt buộc, JPEG/PNG, tối đa 5MB
            'cover_image' => ['nullable', 'image', 'mimes:jpeg,png,jpeg,webp', 'max:5120'],

            // Mô tả không bắt buộc
            'description' => ['nullable', 'string'],

            // Trạng thái
            'status' => ['required', Rule::in(['available', 'unavailable'])],

            // Phải chọn ít nhất 1 thể loại
            'categories' => ['required', 'array', 'min:1'],

            'categories.*' => ['integer', 'exists:categories,id'],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            '*.required' => 'Vui lòng nhập :attribute.',

            '*.string' => ':attribute phải là chuỗi ký tự.',
            '*.integer' => ':attribute phải là số nguyên.',
            '*.numeric' => ':attribute phải là số.',

            '*.max' => ':attribute không được vượt quá :max ký tự.',
            '*.min' => ':attribute phải lớn hơn hoặc bằng :min.',

            '*.unique' => ':attribute đã tồn tại trong hệ thống.',
            '*.exists' => ':attribute được chọn không tồn tại.',

            'price.gt' => ':attribute phải lớn hơn 0.',
            'price.decimal' => ':attribute chỉ được có tối đa 2 chữ số thập phân.',

            'publish_date.date' => ':attribute không hợp lệ.',
            'publish_date.before_or_equal' => ':attribute không được lớn hơn ngày hiện tại.',

            'cover_image.image' => ':attribute phải là file ảnh.',
            'cover_image.mimes' => ':attribute chỉ chấp nhận định dạng JPEG hoặc PNG.',
            'cover_image.max' => ':attribute không được vượt quá 5 MB.',

            'status.in' => ':attribute không hợp lệ.',

            'categories.array' => ':attribute phải là danh sách hợp lệ.',
            'categories.min' => 'Phải chọn ít nhất một :attribute.',
        ];
    }

    /**
     * Custom attribute names.
     */
    public function attributes(): array
    {
        return [
            'isbn' => 'mã ISBN',
            'title' => 'tên sách',
            'author_id' => 'tác giả',
            'price' => 'giá sách',
            'quantity' => 'số lượng',
            'publish_date' => 'ngày xuất bản',
            'cover_image' => 'ảnh bìa',
            'description' => 'mô tả',
            'status' => 'trạng thái',
            'categories' => 'thể loại',
            'categories.*' => 'thể loại',
        ];
    }
}
