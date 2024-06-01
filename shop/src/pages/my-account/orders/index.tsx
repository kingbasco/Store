import { getLayout } from "@components/layout/layout";
import AccountLayout from "@components/my-account/account-layout";
import OrdersTable from "@components/my-account/orders-table";
import ErrorMessage from "@components/ui/error-message";
import Spinner from "@components/ui/loaders/spinner/spinner";
import { useOrders } from "@framework/orders";
import { useState } from "react";
import { useTranslation } from "next-i18next";
import NotFound from "@components/404/not-found";

export { getStaticProps } from "@framework/common.ssr";

export default function OrdersTablePage() {
  const { t } = useTranslation();
  const [page, setPage] = useState(1);
  const {
    orders,
    isLoading: loading,
    error,
  } = useOrders({
    page,
    limit: 5,
  });

  if (error) return <ErrorMessage message={error.message} />;

  function onPagination(current: any) {
    setPage(current);
  }
  return (
    <AccountLayout>
      {loading ? (
        <div className="flex h-full items-center justify-center w-full h-[300px]">
          <Spinner className="!h-full" showText={false} />
        </div>
      ) : (
        <>
          {/* @ts-ignore */}
          {orders?.data?.data?.length ? (
            // @ts-ignore
            <OrdersTable orders={orders} onPagination={onPagination} />
          ) : (
            <NotFound text={t('text-no-order-found')} />
          )}
        </>
      )}
    </AccountLayout>
  );
}

OrdersTablePage.authenticate = true;
OrdersTablePage.getLayout = getLayout;
