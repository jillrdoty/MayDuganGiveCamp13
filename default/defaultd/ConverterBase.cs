using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace UnitConverter_Lab_
{
    public abstract class ConverterBase
    {
        public string FromUnit { get; set; }
        public string ToUnit { get; set; }

        public ConverterBase(string fromUnit, string toUnit)
        {
            FromUnit = fromUnit;
            ToUnit = toUnit;
        }
    }
}
