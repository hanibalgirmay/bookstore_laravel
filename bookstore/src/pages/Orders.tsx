import axios from "axios";
import { useEffect, useState } from "react";
import { decodeJWT } from "../utils/fetaure";
import Card from "../component/Card";
import { useNavigate } from "react-router-dom";
import { MdReadMore } from "react-icons/md";

const Orders = () => {
  const [orderData, setOrderData] = useState([]);

  const router = useNavigate();

  const getOrderData = async () => {
    const token = localStorage.getItem("token");
    if (token) {
      const { sub } = decodeJWT(token);
      await axios
        .get(`${import.meta.env.VITE_APP_API_URL}/api/order/user/${sub}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((res) => {
          console.log(res.data);
          setOrderData(res.data);
        })
        .catch((err) => {
          console.log(err);
        });
    }
  };

  useEffect(() => {
    getOrderData();
  }, []);

  return (
    <div>
      <div className="font-bold text-2xl mb-12">User Orders</div>
      {orderData.length > 0 && (
        <div className="grid grid-cols-1 md:grid-cols-3 gap-4 mt-10 md:mt-3 mx-3 md:mx-0">
          {orderData &&
            orderData?.map((item, index) => (
              <article onClick={() => router(`/orders/details/${item?.id}`)} className="relative isolate flex flex-col justify-end overflow-hidden rounded-2xl px-8 pb-8 pt-40 w-full mx-auto mt-24">
                <img
                  src="https://images.unsplash.com/photo-1499856871958-5b9627545d1a"
                  alt="University of Southern California"
                  className="absolute inset-0 h-full w-full object-cover"
                />
                <div className="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/40"></div>
                <h3 className="z-10 mt-3 text-3xl font-bold text-white">
                  Order {index + 1}
                </h3>
                <div className="z-10 gap-y-1 overflow-hidden text-sm leading-6 text-gray-300">
                  books {JSON.parse(item?.books)?.length}
                </div>
              </article>
            ))}
        </div>
      )}
      {orderData?.length === 0 && (
        <div>
          <div className="flex flex-col justify-center items-center">
            <h2 className="font-bold">No Order Found</h2>
            <MdReadMore size={40} />
            <button
              className="border px-4 py-1 rounded-md"
              onClick={() => router("/")}
            >
              Browse More
            </button>
          </div>
        </div>
      )}
    </div>
  );
};

export default Orders;
