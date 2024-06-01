<?php

namespace Marvel\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Marvel\Database\Models\StoreNotice;
use Marvel\Database\Models\User;
use Marvel\Enums\Permission;
use Marvel\Enums\StoreNoticeType;

trait StoreNoticeable
{

    /**
     * this method will sync read_status of StoreNotice
     *
     * @param StoreNotice $storeNotice
     * @return array | null
     */
    public function syncReadStatus(StoreNotice $storeNotice)
    {
        $userIdArr = match ($storeNotice->type) {
            StoreNoticeType::ALL_VENDOR      => User::permission(Permission::STORE_OWNER)->get()->pluck('id'),
            StoreNoticeType::ALL_SHOP        => $storeNotice->creator->shops->pluck('id'),
            StoreNoticeType::SPECIFIC_SHOP   => $storeNotice->shops->pluck('id'),
            StoreNoticeType::SPECIFIC_VENDOR => $storeNotice->users()->pluck('id'),
        };
        $storeNoticeReadArray =  Arr::map(
            $userIdArr->toArray(),
            fn ($uId) => [
                "store_notice_id" => $storeNotice->id,
                "user_id"         => $uId,
                "is_read"         => $uId === $storeNotice->created_by
            ]
        );
        return $storeNotice->read_status()->sync($storeNoticeReadArray);
    }

    /**
     * This method will attach Users or Shops to StoreNotice
     *
     * @param mixed $request
     * @param StoreNotice $storeNotice
     * @return StoreNotice $storeNotice
     */
    protected function syncUsersOrShops(Request $request, StoreNotice $storeNotice)
    {
        switch ($request->type) {
            case StoreNoticeType::ALL_VENDOR:
                $request->received_by = User::permission(Permission::STORE_OWNER)->pluck('id');
                $storeNotice->users()->sync($request->received_by);
                break;
            case StoreNoticeType::SPECIFIC_VENDOR:
                $storeNotice->users()->sync($request->received_by);
                break;
            case StoreNoticeType::ALL_SHOP:
                $request->received_by = $storeNotice->creator->shops->pluck('id');
                $storeNotice->shops()->sync($request->received_by);
                break;
            case StoreNoticeType::SPECIFIC_SHOP:
                $storeNotice->shops()->sync($request->received_by);
                break;
        }
        return $storeNotice;
    }
}
