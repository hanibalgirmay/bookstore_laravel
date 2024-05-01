import React from "react";
import { MdAddShoppingCart } from "react-icons/md";
import { useCartStore } from "../store/cartStore";

interface IData {
  price: number;
  title: string;
  author: string;
  cover_image: string;
}
interface ICardProp {
  data: IData;
  enableCart: boolean;
  handleLink?: () => void;
  handleCart?: (e: any) => void;
}

const Card = ({
  data,
  handleLink,
  enableCart = true,
  handleCart,
}: ICardProp) => {
  const { cart } = useCartStore();

  return (
    <div
      onClick={handleLink}
      className="w-full overflow-hidden bg-white rounded-lg shadow-sm hover:shadow-lg cursor-pointer"
    >
      <img
        className="object-cover grayscale w-full h-60 hover:scale-105 hover:grayscale-0 ease-in-out transition-all"
        src={data?.cover_image}
        alt={data.title}
      />

      <div className="py-5 text-start pl-4 relative">
        <span className="absolute shadow-lg right-1 -top-8 ring-2 ring-transparent w-14 h-14 flex justify-center items-center text-lg font-bold bg-white rounded-full">
          {data?.price?.toFixed(2)}
        </span>
        {enableCart && (
          <button
            disabled={cart && cart?.filter((i) => i.title === data.title)[0]}
            onClick={() => handleCart(data)}
            className="disabled:pointer-events-none disabled:cursor-not-allowed disabled:opacity-45 absolute hover:bg-purple-400/20 px-2 py-1 rounded-lg bottom-4 right-3"
          >
            <MdAddShoppingCart size={22} color="#000" />
          </button>
        )}
        <a
          href="#"
          className="block text-lg mr-3 truncate text-nowrap font-semibold text-gray-700"
          tabIndex={0}
          role="link"
        >
          {data?.title}
        </a>
        <span className="text-sm text-gray-700">{data?.author}</span>
        <div>
          <small className="border-0 rounded-2xl bg-blue-500 px-4 py-0.5 text-xs text-white">
            {data.tags}
          </small>
        </div>
      </div>
    </div>
  );
};

export default Card;
